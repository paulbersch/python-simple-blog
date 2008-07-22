import post_class, comment_class
import re, os, cherrypy

class Blog(object):
  def __init__(self, author = "Anonymous", url = "http://127.0.0.1"):
    self.posts = []
    self.author = author
    self.url = url
    self.getPosts()

  def getPosts(self):
    self.posts = []
    expression = re.compile('\d*')
    for file in os.listdir(os.getcwd() + '/posts/'):
      if expression.match(file) != None:
        currentPost = post_class.Post()
        filehandle = open('posts/' + file, 'r')
        currentPost = post_class.Post(file, (filehandle.readline())[0:-1], filehandle.read())
        filehandle.close()
        currentPost.markupbody()
        self.posts.append(currentPost)

  def index(self):
    page = []
    header = open('theme/header.php', 'r')
    page.append(header.read())
    header.close()

    for post in self.posts:
      page.append(post.createPost())

    footer = open('theme/footer.php', 'r')
    page.append(footer.read())
    footer.close()
    page = '\n\n'.join(page)
    return page
  index.exposed = True

  def post(self, id):
    header = open('theme/header.php', 'r')
    yield header.read()
    header.close()

    for post in self.posts:
      if post.date == id:
        yield post.createPost(True)
        break

    footer = open('theme/footer.php', 'r')
    yield footer.read()
    footer.close()
  post.exposed = True

  def ajaxedit(self, id, width, height):
    for post in self.posts:
      if post.date == id:
        return post.createEditor(width, height)
  ajaxedit.exposed = True

  @cherrypy.tools.staticdir(root=os.getcwd(), dir='files')
  def files(self):
    yield '<h2>Browsing directory /files</h2>\n'
    for dirpath, dirnames, filenames in os.walk(os.getcwd()+'/files'):
      filenames.sort()
      for filename in filenames:
        yield '<a href="/files/%s">%s</a>\n' % (filename, filename)
  files.exposed = True

  def edit(self, post_title, post_body, post_date):
    for post in self.posts:
      if post.date == post_date:
        post.editPost(post_title, post_body)
        return 'Updated.'
  edit.exposed = True

  def ajaxget(self, id):
    for post in self.posts:
      if post.date == id:
        return post.createPost(False)
  ajaxget.exposed = True
