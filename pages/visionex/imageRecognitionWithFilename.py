import io
import os
import sys
import json 

from google.cloud import vision
from google.cloud.vision import types

def getImageTags(selectedFile):
    client = vision.ImageAnnotatorClient()
    tags = []

    file_name = os.path.join(
        os.path.dirname(__file__),
        'plane.jpg')

    # file_name = os.path.join(
    #     os.path.dirname(__file__),
    #     selectedFile)

    with io.open(file_name, 'rb') as image_file:
        content = image_file.read()

    image = types.Image(content=content)

    response = client.label_detection(image=image)

    labels = response.label_annotations

    print("Labels:")

    for label in labels:
        print(label.description)
        tags.append(label.description)

    return json.dumps(tags)

if __name__ == "__main__":
    print (getImageTags()