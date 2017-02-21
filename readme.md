A mini notification system based on Codeigniter and MongoDB.

Whenever a notification needs to be sent out, it is pushed to the client using Tornado.

Implements persistent connection using long polling and Tornado.


Links:
------

/login

/signup

/profile

/notifications



MongoDB Architecture:
---------------------

There are 5 collections:

- users
  _id
  name
  email
  password
  created
  last_seen


- posts
  _id
  owner_id
  text
  created_on


- comments
  _id
  post_id
  text
  by_user_id
  created_on


- notifications
  _id
  to_user_id
  from_user_id
  post_id
  is_read
  is_fresh
  created_on

- push_notifications
  _id
  users
  is_processed
  created_on
