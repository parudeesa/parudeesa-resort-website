from PIL import Image

img = Image.open('public/images/parudeesa-logo-transp.png')
width, height = img.size

# Crop top 60%
crop_60 = img.crop((0, 0, width, int(height * 0.6)))
crop_60.save('public/images/crop_60.png')

# Crop top 65%
crop_65 = img.crop((0, 0, width, int(height * 0.65)))
crop_65.save('public/images/crop_65.png')

# Crop top 70%
crop_70 = img.crop((0, 0, width, int(height * 0.7)))
crop_70.save('public/images/crop_70.png')

print("Cropped images saved.")
