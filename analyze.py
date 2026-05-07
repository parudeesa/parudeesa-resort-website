from PIL import Image
import numpy as np

img = Image.open('public/images/parudeesa-logo-transp.png')
alpha = np.array(img.split()[-1])

row_sums = alpha.sum(axis=1)

# Find non-empty rows
non_empty_rows = np.where(row_sums > 0)[0]

# Print out the gaps
gaps = []
current_gap_start = -1
for i in range(non_empty_rows[0], non_empty_rows[-1]):
    if row_sums[i] == 0:
        if current_gap_start == -1:
            current_gap_start = i
    else:
        if current_gap_start != -1:
            gaps.append((current_gap_start, i - 1, i - current_gap_start))
            current_gap_start = -1

print("Total Height:", img.height)
print("Non empty bounds:", non_empty_rows[0], "to", non_empty_rows[-1])
print("Significant Gaps (start, end, size):")
for g in gaps:
    if g[2] > 10:
        print(g)
