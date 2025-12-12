# change log

## V1.0

### Fetures

#### Authentication

- login(email,password)
- register(name, email mpassword,confirm_password,role`recruiter|job_seeker`,title,phone,bio)

#### User Profile

- edit user information
- edit password

#### Notifications

- show notifications
- read (all) notification
- delete (all)  notification

#### Recruiter

- CRUD jobs (job, requirments)
- reject applicant
- select applicant
- analize applicants by AI ( all aplicants or select by ids)

#### Job_seeker

- CRUD Qualifications (skills, projects,eductions ,cources)
- browser jobs
- applicant on job
- accept job
- analize profile by AI

#### Jobs browser features

- search by (name,company,location)
- fillter by (recruiter_id ,type,status)
- pagination

#### Admin

##### User Managment

- update user role
- ban/unban user
- browser users
- delete user

##### Staticties

- User staticties ( count by role , total , recent rejecter )
- Job staticties ( count by type , total , total applicants )
- AI Requests staticties ( count by status)
