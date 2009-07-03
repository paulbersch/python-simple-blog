import post_class, comment_class, image_class
import re, os, cherrypy

class Blog(object):
  def __init__(self, author = "Paul", url = "http://overcomplicated.org/about"):
    self.posts = []
    self.author = author
    self.url = url
    self.getPosts()

  def isAuth(self):
    if cherrypy.session.get('authenticated') == True:
      return True
    else:
      return False

  def getPosts(self):
    self.posts = []
    expression = re.compile('\d*')
    post_filenames = os.listdir(os.getcwd() + '/posts/')
    post_filenames.sort(reverse=True)
    for file in post_filenames:
      if expression.match(file) != None:
        currentPost = post_class.Post()
        filehandle = open('posts/' + file, 'r')
        currentPost = post_class.Post(file, (filehandle.readline())[0:-1], filehandle.read())
        filehandle.close()
        currentPost.markupbody()
        self.posts.append(currentPost)

  def index(self):
    page = []
    # read header
    try:
      header = open('theme/header.html', 'r')
      page.append(header.read())
    finally:
      header.close()

    if self.isAuth():
      page.append('<div class="createnew">+</div>')

    # iterate through post list 
    for post in self.posts:
      page.append(post.createPost())

    # read footer
    try:
      footer = open('theme/footer.html', 'r')
      page.append(footer.read())
    finally:
      footer.close()

    # join the pieces into a single string and return
    page = '\n\n'.join(page)
    return page
  index.exposed = True

  def about(self):
    try:
      f = open('pages/about.html', 'r')
      contents = f.read()
    finally:
      f.close()
    return contents
  about.exposed = True

  def resume(self):
    try:
      f = open('pages/resume.html', 'r')
      contents = f.read()
    finally:
      f.close()
    return contents
  resume.exposed = True

  def post(self, id):
    try:
      header = open('theme/header.html', 'r')
      yield header.read()
    finally:
      header.close()

    for post in self.posts:
      if post.date == id:
        yield post.createPost(True)
        break

    try:
      footer = open('theme/footer.html', 'r')
      yield footer.read()
    finally:
      footer.close()
  post.exposed = True

  def ajaxedit(self, id, width, height):
    if not self.isAuth():
      raise cherrypy.HTTPRedirect('/')
      
    for post in self.posts:
      if post.date == id:
        return post.createEditor(width, height)
  ajaxedit.exposed = True

  def loginwidget(self):
    try:
      f = open('theme/loginwidget.html')
      yield f.read()
    finally:
      f.close()
  loginwidget.exposed = True

  def login(self, username, password):
    if username == 'paul' and password == 'ponies':
      cherrypy.session['authenticated'] = True
    raise cherrypy.HTTPRedirect('/')
  login.exposed = True

  def logout(self):
    cherrypy.session.clear()
    raise cherrypy.HTTPRedirect('/')
  logout.exposed = True

  @cherrypy.tools.staticdir(root=os.getcwd(), dir='files')
  def files(self):
    yield '<h2>Browsing directory /files</h2>\n'
    for dirpath, dirnames, filenames in os.walk(os.getcwd()+'/files'):
      filenames.sort()
      for filename in filenames:
        yield '<a href="/files/%s">%s</a><br>' % (filename, filename)
  files.exposed = True

  def edit(self, post_title, post_body, post_date):
    if not self.isAuth():
      raise cherrypy.HTTPRedirect('/')
    for post in self.posts:
      if post.date == post_date:
        post.editPost(post_title, post_body)
        return 'Updated.'

    # if it is not an existing post, then save it as a new post.
    post = post_class.Post()
    post.editPost(post_title, post_body)
    # add that post to the post cache
    self.getPosts()
    return 'New Post Saved.'
    #raise cherrypy.HTTPRedirect('/')
  edit.exposed = True

  def ajaxget(self, id):
    if not self.isAuth():
      raise cherrypy.HTTPRedirect('/')
    for post in self.posts:
      if post.date == id:
        return post.createPost(False)
  ajaxget.exposed = True

  def ajaxnewpost(self, width, height):
    if not self.isAuth():
      raise cherrypy.HTTPRedirect('/')
    post = post_class.Post(title='New Post', body='This is a new post') 
    return post.createEditor(width, height)
  ajaxnewpost.exposed = True
