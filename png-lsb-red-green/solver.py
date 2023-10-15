import png

imagePath = "encoded.png"

flagLength = int(input("Enter estimated flag length: "))

imageFile = open(imagePath, "rb")
reader = png.Reader(imageFile)
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

redBytes = []
greenBytes = []
for i in range(flagLength * 8):
	rxLoc = (i * 3) % (width * 3)
	gxLoc = rxLoc + 1
	yLoc = (i * 3) // (width * 3)
	redBytes.append(pixels[yLoc][rxLoc])
	greenBytes.append(pixels[yLoc][gxLoc])

output = []
for i in range(flagLength * 8):
	if i % 8 == 0:
		output.append(0)
	redBit = redBytes[i] & 0x01
	greenBit = greenBytes[i] & 0x01
	flagBit = redBit ^ greenBit
	output[i // 8] = output[i // 8] | (flagBit << (7 - (i % 8)))

outputString = ""
for letter in output:
	outputString += chr(letter)

print(outputString)

imageFile.close()