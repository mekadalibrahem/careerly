# change log

## V1.0

### Features

#### Authentication

- login(email,password)
- register(name, email password,confirm_password,role`recruiter|job_seeker`,title,phone,bio)

#### User Profile

- edit user information
- edit password

#### Notifications

- show notifications
- read (all) notification
- delete (all)  notification

#### Recruiter

- CRUD jobs (job, requirements)
- reject applicant
- select applicant
- analyze applicants by AI ( all applicants or select by ids)

#### Job_seeker

- CRUD Qualifications (skills, projects,educations ,courses)
- browser jobs
- applicant on job
- accept job
- analyze profile by AI
- export cv as PDF file ( file will delete automatic from system after 1 Day)

#### Jobs browser features

- search by (name,company,location)
- filter by (recruiter_id ,type,status)
- pagination

#### Admin

##### User Management

- update user role
- ban/unban user
- browser users
- delete user

##### Support tickets Management

- view all tickets 
- view ticket by id 
- update status of ticket ( optional note , append)
- update note if ticket  (option append)

> Note : `append` option for add note as top of old note or if false replace old note with new one

##### Statistics

- User statics ( count by role , total , recent rejecter )
- Job statics ( count by type , total , total applicants )
- AI Requests statics ( count by status)

#### Schedule tasks

- Check AI request if you take long time (more than 1 day ) set as TIMEOUT status  run every day
- Check all download temp file if it is older than 1 day  mark as expired and delete form storage 
