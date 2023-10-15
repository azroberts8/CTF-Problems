import png
import os

pwd = input("Enter the passphrase to encrypt with: ")
pwd = "'[password: " + pwd + "]'"

# embed the flag in flag.txt encrypted with provided passphrase
os.system("steghide embed -cf original-images/flag.jpg -sf encoded-images/flag.jpg -ef flag.txt -p " + pwd)

# store the passphrase in the least significant bits of key.png
keyFile = open("original-images/key.png", "rb")
keyReader = png.Reader(keyFile)
keyContents = keyReader.read()
keyWidth = keyContents[3]['size'][0]
keyHeight = keyContents[3]['size'][1]

## load pixel values of keyfile into matrix
keyPixels = [[0] * (keyWidth * 3) for i in range(keyHeight)]
x, y = 0, 0
for row in keyContents[2]:
    for col in row:
        keyPixels[y][x] = col
        x += 1
    x = 0
    y += 1

## encode the bits of the passphrase into the LSB of each color channel of each pixel
for i in range(len(pwd) * 8):
    xLoc = i % (keyWidth * 3)
    yLoc = i // (keyWidth * 3)
    pwdBit = (bytes(pwd, 'utf-8')[i // 8] >> (7 - (i % 8))) & 0x01
    keyPixels[yLoc][xLoc] = (keyPixels[yLoc][xLoc] & 0xFE) + pwdBit

## write the pixels to the output key.png
keyOutFile = open("encoded-images/key.png", "wb")
keyWriter = png.Writer(keyWidth, keyHeight, greyscale = False)
keyWriter.write(keyOutFile, keyPixels)
keyFile.close()
keyOutFile.close()

# compress flag.jpg and key.png into zip file
os.system("tar -cJf encoded-images/archive.tar.xz --directory=encoded-images/ flag.jpg key.png")

# append zip file bytes to cover.jpg
os.system("cat original-images/cover.jpg > big-image.jpg")
os.system("cat encoded-images/archive.tar.xz >> big-image.jpg")
