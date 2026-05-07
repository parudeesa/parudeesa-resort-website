from rembg import remove
from PIL import Image, ImageEnhance
import os

input_path = 'public/images/parudeesalogo.jpeg'
output_path = 'public/images/parudeesa-logo-transp.png'
final_path = 'public/images/parudeesa-logo.png'

# 1. Read input image
input_image = Image.open(input_path)

# 2. Remove background
# Use post_process_mask=True to clean up jagged edges
output_image = remove(input_image, post_process_mask=True)

# 3. Enhance Contrast slightly
enhancer = ImageEnhance.Contrast(output_image)
# Enhance contrast by a small amount (1.1 = 10% more contrast)
output_image = enhancer.enhance(1.1)

# 4. Save to temporary output
output_image.save(output_path, "PNG")

# 5. Overwrite original png that the website uses
output_image.save(final_path, "PNG")

print("Background removed and contrast enhanced successfully.")
