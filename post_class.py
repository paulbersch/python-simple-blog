from datetime import datetime
import textile

class Post(object):
  def __init__(self, date = datetime.today().strftime('%Y%m%d%H%M%S'), title = "", body = ""):
    self.date = date
    self.title = title
    self.body = body
    self.markedupbody = textile.textile(self.body)

  def markupbody(self):
    self.markedupbody = textile.textile(self.body)

  def createPost(self, createDiv = True):
    div = []
    if (createDiv): div.append('''<div class="post" id="%s">''' % self.date )
    div.append('''<a href="post?id=%s" class="thesubject">''' % self.date + self.title + '''</a>''')
    div.append('''<h3 class="time">%s-%s-%s''' % (self.date[4:6], self.date[6:8], self.date[:4]) + '''</h3>''')
    div.append('''<div class="thebody">\n''' + self.markedupbody +'''\n</div>''')
    if (createDiv): div.append('''\n</div>''')
    div = '\n'.join(div)
    return div

  def createEditor(self, width, height):
    f = open('theme/editor.html')
    editor_html = f.read()
    f.close()

    return editor_html % (self.title, width, height, self.body, self.date, self.date)

  def editPost(self, title, body):
    postfile = open('posts/' + self.date, 'w')
    postfile.write('\n'.join([title, body]))
    postfile.close()
    self.body = body
    self.title = title
    self.markupbody()
