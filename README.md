#King David

1. You need to create user authorization.
1. The user can create and update boards.
1. The user can attach a task to each board.
1. The user can create custom labels, then he can attach multiple labels to the task.
1. The task must have a status (backlog, development, done, review).
1. We can filter tasks by labels, status.
1. The user can attach an image to the task (the image must be cropped into 2 formats: desktop, mobile). 1. Image cropping must be asynchronous. (http://image.intervention.io/).
1. We need to keep logs in MongoDB table “logs” for each update of task (create, update, delete). Who made the change, when, and what was changed (use https://github.com/jenssegers/laravel-mongodb).
