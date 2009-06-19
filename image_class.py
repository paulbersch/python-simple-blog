import os

class Image(object):
  def __init__(self, count = 3, imagedirectory = 'images'):
    self.images = []
    self.imagecount = count
    self.imagedirectory = imagedirectory

  def getImages(self):
    self.images = []
    for file in os.listdir(os.getcwd() + '/%s/' % self.imagedirectory):
      if file[-3:] in ['jpg', 'png', 'gif']:
        self.images.append(file)
