# Generates a forensic CTF problem using a combination of Least Significant Bit (LSB) and XOR.
# requires pypng library to parse and encode PNG files
#
# Starts at the most top-left pixel and iterates left to right, top to bottom;
# Loads the red channel value of the first 8*flag_length pixels;
# XORs each bit of the flag with the LSB of each loaded red value
# Stores each encoded bit in the least significant bit of the green channel of the pixels
#
# Solution:
# XOR the LSB of the red and green values of the first pixels of the image

import png

# change imagePath and flag depending on problem
imagePath = "original.png"
flag = input("Enter the flag you would like to embed: ")


inputFile = open(imagePath, "rb")
reader = png.Reader(inputFile)
contents = reader.read()
width = contents[3]['size'][0]
height = contents[3]['size'][1]

# get pixel values from generator into matrix
pixels = [[0] * (width * 3) for i in range(height)] # width is x3 for each channel (stored as RGBRGBRGB...)
x = 0
y = 0
for row in contents[2]:
	for col in row:
		pixels[y][x] = col
		x += 1
	x = 0
	y += 1

# get the image bytes to xor with
dataLength = len(flag) * 8
redBytes = []
greenBytes = []
for i in range(dataLength):
	rxLoc = (i * 3) % (width * 3)
	gxLoc = rxLoc + 1
	yLoc = (i * 3) // (width * 3)
	redBytes.append(pixels[yLoc][rxLoc])
	greenBytes.append(pixels[yLoc][gxLoc])

# xor least significant bit of each red byte with corresponding flag bit
# save result in least significant bit of green byte
for i in range(dataLength):
	flagBit = (bytes(flag, 'utf-8')[i // 8] >> ( 7- (i % 8))) & 0x01
	encodedBit = (redBytes[i] & 0x01) ^ flagBit
	greenBytes[i] = (greenBytes[i] & 0xFE) + encodedBit

# add modified green bits to pixel matrix
for i in range(dataLength):
	xLoc = (i * 3) % (width * 3) + 1
	yLoc = (i * 3) // (width * 3)
	pixels[yLoc][xLoc] = greenBytes[i]

outputFile = open('encoded.png', 'wb')
writer = png.Writer(width, height, greyscale = False)
writer.write(outputFile, pixels)
outputFile.close()

inputFile.close()