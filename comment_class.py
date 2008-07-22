import post_class
from datetime import datetime

class Comment(post_class.Post):
  def __init__(self, date = datetime.today(), title = "", body = "", commenterName = "Anonymous"):
    super(Comment, self).__init__(date, title, body)
    self.commenterName = commenterName
