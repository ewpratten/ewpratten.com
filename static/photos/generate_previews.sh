#! /bin/bash
set -ex

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo "ImageMagick is not installed. Please install it before running this script."
    exit 1
fi


# Get the directory of this script
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

# Find all images with extension ".png", ".jpg", or ".jpeg"
# NOTE: Ignore any image containing ".preview." in the name
IMAGES=$(find $DIR -type f -name "*.png" -o -name "*.jpg" -o -name "*.jpeg" | grep -v ".preview.")

# Loop through all images
for IMAGE in $IMAGES; do
    # Create the preview file name (file.preview.ext)
    PREVIEW="${IMAGE%.*}.preview.${IMAGE##*.}"
    
    # If the file already exists, skip it
    if [ -f "$PREVIEW" ]; then
        echo "Preview already exists for: $IMAGE"
        continue
    fi
    
    # Check if the image is bigger than 1440x1440
    WIDTH=$(identify -format "%w" $IMAGE)
    HEIGHT=$(identify -format "%h" $IMAGE)
    
    if [ $WIDTH -gt 1440 ] || [ $HEIGHT -gt 1440 ]; then
        # Create the preview. This should be a 2 fifths resolution version of the original image
        convert $IMAGE -resize 40% $PREVIEW
    elif [ $WIDTH -gt 720 ] || [ $HEIGHT -gt 720 ]; then
        # Create the preview. This should be a half resolution version of the original image
        convert $IMAGE -resize 50% $PREVIEW
    else
        # Create the preview. This should be the original image
        cp $IMAGE $PREVIEW
    fi
    
    echo "Created preview for: $IMAGE"
done