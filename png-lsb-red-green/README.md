# PNG Least Significant Bit Obfuscator

## Concept
This problem takes advantage of the ability to embed and obfuscate information in the least significant bit of PNG image pixels. The color of each pixel in an image can be represented by 3 bytes corresponding to the intensity of the red, green, and blue channels in that pixel. Considering that there are 256 different intensity values on each channel, a variance of 1 is nearly imperceptible to the viewer of the image.

We can take advange of this and embed any arbitrary data in the least significant bit of a color channel on each pixel in an image resulting in nearly no visual difference to the user espicially if the image has a high amount of noise to begin with. Read more about steganography [here](https://en.wikipedia.org/wiki/Steganography).

This problem generator takes the data obfuscation a step further by first XORing our secret data with the least significant bits of the red channel in our image, then storing this 'ciphertext' in the least significant bit of the green channel in our image. This further obfuscates our secret data because if someone were inspect the least significant bits of any of the 3 color channels, the data would appear nonsensical unless they knew to XOR the data embedded in the green channel with the data embedded in the red channel.

## Solution
To solve this problem one must first extract the least significant bits of both the red and green channels of the first n pixels of the image reading left-to-right top-to-bottom where n is the length of the flag × 8. It is fine to over-estimate the number of characters in the flag as any data after the flag can be discarded. Then, XOR the LSB data of the red and green channels together to recieve the flag in ASCII.

## Tool Usage
The generator and the solver scripts require the `pypng` library so first ensure that this is installed by using `pip install pypng`.

### Generator
Choose a PNG file to use as your base image to hide the flag in. This image must have a total pixel count of at least 8× the length of the intended flag length. **Example: if the flag is 12 characters long then the image must contain at least 96 total pixels. A 10x10 pixel image will suffice because it has 100 available pixels.** Copy the base image file to the same directory as the generator script and rename it to `original.png`.

Execute the generator script using `python3 generator.py`. You'll be prompted to enter your flag. Once you enter your flag the generator may take a few seconds depending on the size of your image to embed the flag. The generator will save the image with the embedded flag as `encoded.png`.

### Solver
Make sure the image with the embedded flag is located in the same directory as the solver script and named as `encoded.png`. Run the solver script using `python3 solver.py`. The solver will prompt you to estimate the length of the flag. It is completely fine to overestimate the length of the flag as any additional data will be nonsense appened to the end of the flag that you can remove. The solver may take a moment to extract the flag depending on the size of the image.

## Example Problem
Hint: I can't decide which of these colors are the least significant, red xor green 🤔
![Suspicious rubix cube & dry erase markers](/encoded.png)