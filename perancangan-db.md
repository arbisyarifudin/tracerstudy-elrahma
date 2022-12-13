# DATABASE

# TABLE

## settings
- id
- label
- key
- input_type
- data_type
- value

## majors
- id
- code UNIQUE
- name
- level

## major_interests
- id
- major_id **
- code UNIQUE
- name

## users
- id
<!-- - uid -->
- name
- uname
- email 
- password
- email_verified_at
- type

## batchs
- id
- name

## alumni
- id
- user_id
- nim
- fullname
- email
- gender NULLABLE
- phone_number NULLABLE
- wa_number NULLABLE
- place_of_birth NULLABLE
- date_of_birth NULLABLE
- address NULLABLE
- province_id ** NULLABLE
- regency_id ** NULLABLE
- enter_year NULLABLE
- graduation_year NULLABLE
- major_id ** NULLABLE
- major_interest_id ** NULLABLE
- gpa NULLABLE
- photo NULLABLE
- suggestion NULLABLE
- is_active BOOL
<!-- - contacts JSON -->

## alumni_contacts
- id
- alumni_id **
- name
- value
  
## alumni_educations
- id
- alumni_id **
- institution_name
- address
- major_name NULLABLE
- level
- enter_year
- graduate_year NULLABLE


## alumni_jobs
- id
- alumni_id **
- bussiness_category_id **
- institution_name
- institution_contacts JSON
- address
- job_title
- start_year
- end_year

## ts_form
- id
- title
- name UNIQUE
- description
- is_active
  
## ts_form_sections
- id 
- form_id **
- title
- description
- order

## ts_form_questions
- id 
- form_section_id ** NULLABLE
- label
- hint NULLABLE
- order
- exportable BOOLEAN
<!-- - export_code NULLABLE -->
<!-- - export_order NULLABLE -->
- input_type NULLABLE
- input_required BOOL
<!-- - options NULLABLE -->
- is_editable
<!-- - from_existing -->
- form_question_parent_id **

## ts_form_question_options
- id
- form_question_id **
- text
- value
- next_question_id NULLABLE

<!-- ## ts_form_template
- id
- label
- name
- table_name 
- column_name -->

## ts_form_responses
- id
- form_id ** NULLABLE
- alumni_id **
- created_at
- updated_at

## ts_form_response_answers
- id
- form_response_id **
- form_question_id **
- form_response_answer


<!-- CONTENT / INFORMATION -->

## contents
- id
- title
- excerpt
- body
- created_by **
- last_update_by **
- created_at
- updated_at

## categories
- id
- title
- description
- type

## content_has_categories
- id *
- content_id **
- category_id **