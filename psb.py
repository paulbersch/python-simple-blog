import blog_class
import cherrypy
import re, os

# update config file to current working directory
def updateConfig():
  regex = re.compile('current_directory')

  # open base file
  f = open('post.config.base', 'r')
  contents = f.read()
  contents = regex.sub(os.getcwd(), contents)
  f.close()

  # write new config file
  f = open('post.config', 'w')
  f.write(contents)
  f.close()

updateConfig()

cherrypy.tree.mount(blog_class.Blog(), config='post.config')

if __name__ == '__main__':
  import os.path
  cherrypy.config.update(os.path.join(os.path.dirname(__file__), 'overcomplicated.conf'))

  #(deprecated)
  #cherrypy.server.quickstart()
  cherrypy.engine.start()

