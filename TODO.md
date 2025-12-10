# TODO

## Phase 1: Critical Job Fields

- Add company field to works table ✅
- Add location field to works table ✅
- Add type field to works table (enum: full-time, part-time, contract, internship) ✅
- Add salary_range field to works table ✅
- Add requirements field to works table (text) ✅
- Add benefits field to works table (text) ✅
- Add status field to works table (enum: active, closed) ✅
- Update POST /works to accept all fields ✅
- Update PUT /works/{work_id} to accept all fields ✅
- Update GET /works to return all fields ✅

## Phase 2: User Profile

- Add phone field to users table ✅
- Add bio field to users table ✅
- Update PUT /user/{user_id}/update to accept phone and bio ✅
- Keep `title` for job title ✅

## Phase 3: Admin Endpoints

- Implement GET /admin/users ✅
- Implement POST /admin/users/{user_id}/ban ✅
- Implement POST /admin/users/{user_id}/unban ✅
- Implement DELETE /admin/users/{user_id} ✅
- Implement POST /admin/users/{user_id}/role ✅
- Implement GET /admin/stats ✅
- Implement GET /admin/roles

## Phase 4: Application Management

- Implement PUT /works/{work_id}/applicants/{applicant_id} (for status updates) ✅
- Include user details in GET /works/{work_id}/applicants response ✅
- Add has_applied field to GET /works/{work_id} response (when authenticated)
- Add applications_count to GET /works response (for recruiters) ✅

## Phase 5: Additional Features

- Implement POST /support (support tickets)
- Implement GET /works?recruiter_id={user_id} (filtering) ✅
- Implement POST /ai/analyze-applicant (AI analysis) ✅
- Fix typo: /works/{work_id}/workRequirments → workRequirements ✅
