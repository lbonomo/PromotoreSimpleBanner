#!/bin/bash

# Banner
xcf2png banner.xcf -o banner-1544x500-rtl.png
convert banner-1544x500-rtl.png -resize 50% banner-772x250-rtl.png
# Icon
xcf2png icon.xcf -o icon-256x256.png
convert icon-256x256.png -resize 50% icon-128x128.png