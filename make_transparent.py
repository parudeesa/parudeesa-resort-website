from PIL import Image
import numpy as np

img = Image.open('public/images/parudeesalogo.jpeg').convert('RGBA')
data = np.array(img)

r = data[:, :, 0].astype(float)
g = data[:, :, 1].astype(float)
b = data[:, :, 2].astype(float)

# Calculate distance from white (255, 255, 255)
dist = np.sqrt((255 - r)**2 + (255 - g)**2 + (255 - b)**2)

# Set alpha based on distance from white
# If dist is 0 (pure white), alpha is 0
# If dist > 80, alpha is 255 (fully opaque)
# Smooth transition for anti-aliasing
alpha = np.clip(dist * (255 / 80), 0, 255).astype(np.uint8)

# To remove white fringing, we can darken the RGB channels slightly where alpha is low, 
# or just leave them. Since the website background is beige, leaving original RGB is fine.
data[:, :, 3] = alpha

new_img = Image.fromarray(data)

# Let's crop it to remove "The Lake View Resort".
# The text "PARUDEESA" ends around row 662 (from earlier rembg output, wait rembg erased the text? No, rembg's non-empty rows were 18 to 662. The sun icon itself might be 18 to 662!
# Let's crop top 60% (int(889 * 0.6) = 533) or let's not crop yet and check the image.

new_img.save('public/images/test_transparent.png')
print("Image saved with transparency.")
