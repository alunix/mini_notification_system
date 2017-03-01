A mini notification system based on Codeigniter and MongoDB.

Whenever a notification needs to be sent out, it is pushed to the client using Tornado.

**Implements persistent connection using long polling and Tornado.**

Hence, notifications get pushed instantly to user, if the user is online and connected.

The Tornado implementation is here:
https://github.com/harkirat1892/tornado_push_server


Links:
------

/login

/signup

/profile

/notifications



MongoDB Architecture:
---------------------

There are 5 collections:

- <b>users</b>

  _id

  name
  
  email
  
  password
  
  created
  
  last_seen


- <b>posts</b>
  
  _id
  
  owner_id
  
  text
  
  created_on


- <b>comments</b>
  
  _id
  
  post_id
  
  text
  
  by_user_id
  
  created_on


- <b>notifications</b>
  
  _id
  
  to_user_id
  
  from_user_id
  
  post_id
  
  is_read
  
  is_fresh
  
  created_on


- <b>push_notifications</b>
  
  _id
  
  users
  
  is_processed
  
  created_on
