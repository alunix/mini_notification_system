A mini notification system based on Codeigniter and MongoDB.

Attempting to make it work with Tornado, for persistent connection.


Links:
------

/login

/signup

/profile

/notifications



MongoDB Architecture:
---------------------

There are 4 collections:

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

