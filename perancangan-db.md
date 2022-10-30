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

## major_interests
- id
- major_id **
- code UNIQUE
- name

## users
- id
- uid
- name
- email 
- password
- email_verified_at

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
- entered_year_id ** NULLABLE
- graduation_year NULLABLE
- major_id ** NULLABLE
- major_interest_id ** NULLABLE
- gpa NULLABLE
- photo NULLABLE
- suggestion NULLABLE
- socials JSON
  
## alumni_educations
- id
- alumni_id **
- institution_name
- address
- major_name NULLABLE
- level
- entered_year
- graduated_year NULLABLE

# bussiness_categories
- id
- name

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
- label
- description
- order

## ts_form_questions
- id 
- form_section_id ** NULLABLE
- label
- code 
- exportable
- info NULLABLE
- input_type NULLABLE
- options NULLABLE
- order
- form_question_parent_id **

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