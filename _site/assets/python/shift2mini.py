import base64
import hashlib

_version = 2

def execLayerSeq(layers, msg, key, decode=False):
    # Make sure to reverse layers for decoding
    if decode:
        for layer in layers[::-1]:
            msg, key = layer.decode(msg, key)
    else:
        for layer in layers:
            msg, key = layer.encode(msg, key)
    
    return msg

class BitshiftLayer(object):

    def encode(self, file, key):
        # Encode once to allow for binary data
        file = base64.b85encode(file.encode())
        output = ""

        # Iterate and shift
        for i, byte in enumerate(file):
            # Mod the current bit
            output += chr(byte ^ key[i%len(key) - 1])

            # Mod the key
            key.append(i%key[0])

        # Final encoding
        output = base64.b85encode(output.encode())

        # Return as string
        return (output.decode(), key)
    
    def decode(self, file, key):
        # Decode the file to shifted bytes
        try:
            file = base64.b85decode(file.strip().encode())
        except:
            return ("INVALID DATA", key)
        output = ""

        for i, byte in enumerate(file):
            # Unmod the current byte
            mod = byte ^ key[i%len(key) - 1]
            if mod not in range(0x110000):
                mod = 0
            output += chr(mod)

            # Mod the current key
            key.append(i%key[0])

        # Pull the resulting b64 back to binary if needed
        # This may fail due to "incorrect padding" from a wrong key
        # Just return some random text in this case for now
        try:
            output = base64.b85decode(output.encode()).decode()
        except:
            output = output

        # Return as bytes
        return (output, key)
        
class DataHeaderLayer(object):

    def encode(self, file, key):
        version = _version
        fdl = len(file)
        base = 85

        # Construct header
        header = []
        header.append(version)
        header += list((fdl & 0xFFFFFFFF).to_bytes(4, 'big'))
        header += list((base & 0xFFFFFFFF).to_bytes(2, 'big'))

        header = base64.b64encode(bytes(header)).decode()

        return (header + file, key)
    
    def decode(self, file, key):
        # Header is the first 12 chars
        header = file[:12]
        file = file[12:]
        try:
            header = base64.b64decode(header.encode())
        except:
            return ("INVALID DATA", key)
        header = bytes(header)

        version = header[0]

        # Conversion failed if the version is incorrect
        if version != _version:
            return ("INVALID DATA", key)
        
        fdl = header[:5][1:]
        fdl = int.from_bytes(fdl, byteorder='big')
        
        # Chop off possible extra data
        file = file[:fdl]

        return (file, key)

def key2shifts(key: str) -> list:
    output = []

    for char in key:
        output.append(ord(char))

    return output


crypt_layers = [
    DataHeaderLayer(),
    BitshiftLayer()
    
]

def encode(file, key):
    return execLayerSeq(crypt_layers, file, key)

def decode(file, key):
    return execLayerSeq(crypt_layers, file, key, decode=True)