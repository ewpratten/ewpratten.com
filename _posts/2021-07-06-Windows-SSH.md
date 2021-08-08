---
layout: page
title:  "Configuring a native SSH server on Windows 10"
description: "A tutorial for future me"
date:   2021-07-07
written: 2021-07-07 
tags: reference
excerpt: >-
    I commonly need to configure SSH servers on remote Windows 10 boxes. This post covers the whole process.
---

Between work, school, and just helping various people out with things, I end up needing to quickly spin up SSH servers on windows machines *a lot*. Despite what you might think, this functionality is actually built right in to Windows 10, and fairly easy to enable.

## Enabling the OpenSSH service

Just like many Linux machines, Windows uses the [OpenSSH](https://www.openssh.com/) server internally. This used to be controlled by a feature flag in the *"Turn Windows features on or off"* dialog, but this can now be done through [PowerShell](https://en.wikipedia.org/wiki/PowerShell) (as a local administrator).

First, we need to add the OpenSSH capability to Windows, and enable the service:

```powershell
# Add the capability
Add-WindowsCapability -Online -Name OpenSSH.Server~~~~0.0.1.0
Start-Service sshd

# Start on boot
Set-Service -Name sshd -StartupType 'Automatic'
```

This should also automatically configure the firewall, but you can manually verify this and enable the rules yourself if needed:

```powershell
# Check firewall
Get-NetFirewallRule -Name *ssh*

# If needed, add a firewall rule
New-NetFirewallRule -Name sshd -DisplayName 'OpenSSH Server (sshd)' -Enabled True -Direction Inbound -Protocol TCP -Action Allow -LocalPort 22
```

## Setting up key-based authentication

While we are on the Windows side, it is a good idea to install Git and Git Bash from [here](https://git-scm.com/downloads). Then, inside Git Bash, run the following to generate SSH keys on the Windows server:

```sh
# Generate
ssh-keygen.exe

# View the public key
cat ~/.ssh/id_rsa.pub
```

On your client (for me, a Linux laptop), you must generate SSH keys, and copy the public key over to the Windows server.

The path for the file in Windows depends on your user type. Regular users append their keys to `C:\Users\<username>\.ssh\authorized_keys` (remembering to change the `<username>`), whereas local admins must append their keys to `C:\ProgramData\ssh\administrators_authorized_keys`, then update the permissions on that file with:

```powershell
icacls.exe "C:\ProgramData\ssh\administrators_authorized_keys" /inheritance:r /grant "Administrators:F" /grant "SYSTEM:F"
```

## Configuring SSH clients to automatically launch bash

By default, incoming SSH connections spawn a `cmd.exe` shell. I much prefer being dropped straight into [Bash](https://en.wikipedia.org/wiki/Bash_(Unix_shell)).

To do this, you must modify your client's `~/.ssh/config` file to add a `RemoteCommand`. An example for one of my machines looks similar to:

```
Host hostname
	HostName hostname.example.com
	RequestTTY force
	User ewpratten
	RemoteCommand powershell "& 'C:\Program Files\Git\bin\sh.exe' --login"
```

The last line is the actual command to launch Bash (through PowerShell).

## Uninstalling and disabling OpenSSH

This is a simple one-liner:

```powershell
Remove-WindowsCapability -Online -Name OpenSSH.Server~~~~0.0.1.0
```
