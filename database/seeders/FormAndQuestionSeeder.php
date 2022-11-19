<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormSection;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FormAndQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Form Tracestudy 2021',
                // 'tag' => 'ts2021',
                'slug' => 'form-ts-2021',
                'description' => 'Form Tracestudy 2021',
                'sections' => [
                    [
                        'title' => 'Identitas',
                        'description' => 'Isi dengan identitas Anda',
                        'questions' => [
                            [
                                'text' => 'Nomor Mahasiswa',
                                'code' => null,
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => true,
                                'default_value' => '{alumni.nim}',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'nimmhs',
                            ],
                            [
                                'text' => 'Kode Perguruan Tinggi',
                                'code' => null,
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => true,
                                'default_value' => '053030',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'kodeptmhs`',
                            ],
                            [
                                'text' => 'Tahun Lulus',
                                'code' => null,
                                'hint' => null,
                                'type' => 'year',
                                // 'is_required' => true,
                                'default_value' => '{alumni.batch.year}',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'tahun_lulus',
                            ],
                            [
                                'text' => 'Kode Prodi',
                                'code' => null,
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => true,
                                'default_value' => '{alumni.major.code}',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'kodeprmhs',
                            ],
                            [
                                'text' => 'Nama Mahasiswa',
                                'code' => null,
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => true,
                                'default_value' => '{alumni.fullname}',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'namamhs',
                            ],
                            [
                                'text' => 'Nomor Telp/HP',
                                'code' => null,
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => true,
                                'default_value' => '{alumni.phone_number}',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                // 'export_order' => null,
                            ],
                            [
                                'text' => 'Alamat Email',
                                'code' => null,
                                'hint' => null,
                                'type' => 'email',
                                // 'is_required' => true,
                                'default_value' => '{alumni.email}',
                                'is_default_value_editable' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                // 'export_order' => null,
                            ],
                            [
                                'text' => 'NIK',
                                'code' => null,
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => true,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'nik',
                            ],
                            [
                                'text' => 'NPWP',
                                'code' => null,
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => true,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'npwp',
                            ],
                        ]
                    ],
                    [
                        'title' => 'Kuisioner Wajib',
                        'description' => null,
                        'questions' => [
                            [
                                'text' => 'Jelaskan status Anda saat ini?',
                                'code' => 'F8',
                                'hint' => null,
                                'type' => 'multiple choice',
                                // 'is_required' => true,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f8',
                                'options' => [
                                    [
                                        'text' => 'Bekerja (Full-time/Part-time)',
                                        'value' => 1,
                                    ],
                                    [
                                        'text' => 'Wiraswasta',
                                        'value' => 3,
                                    ],
                                    [
                                        'text' => 'Melanjutkan pendidikan',
                                        'value' => 4,
                                    ],
                                    [
                                        'text' => 'Sedang mencari kerja',
                                        'value' => 5,
                                    ],
                                    [
                                        'text' => 'Belum memungkinkan bekerja',
                                        'value' => 2,
                                    ]
                                ]
                            ],
                            [
                                'text' => 'Apakah anda telah mendapatkan pekerjaan <= 6 bulan / termasuk bekerja sebelum lulus ?',
                                'code' => 'F5-04',
                                'hint' => null,
                                'type' => 'multiple choice',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f504',
                                'options' => [
                                    [
                                        'text' => 'Ya',
                                        'value' => 1,
                                        'next_question_id' => 'F5-02'
                                    ],
                                    [
                                        'text' => 'Tidak',
                                        'value' => 2,
                                    ],
                                ],
                            ],
                            [
                                'text' => 'Dalam berapa bulan anda mendapatkan pekerjaan ?',
                                'code' => 'F5-02',
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => 'F5-05',
                                // 'is_exportable' => true,
                                // 'export_code' => 'f502',
                            ],
                            [
                                'text' => 'Berapa rata-rata pendapatan anda per bulan ? (take home pay)',
                                'code' => 'F5-05',
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f505',
                            ],
                            [
                                'text' => 'Dalam berapa bulan anda mendapatkan pekerjaan ?',
                                'code' => 'F5-06',
                                'hint' => null,
                                'type' => 'number',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f506',
                            ],
                            [
                                'text' => 'Dimana lokasi tempat Anda bekerja?',
                                'code' => 'F5-10',
                                'hint' => null,
                                'type' => 'multiple question',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => true,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                'question_childs' => [
                                    [
                                        'text' => 'Provinsi',
                                        'code' => 'F5-A1',
                                        'hint' => null,
                                        'type' => 'select province',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => 'F5-A2',
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f5a1',
                                    ],
                                    [
                                        'text' => 'Kabupaten/Kota',
                                        'code' => 'F5-A2',
                                        'hint' => null,
                                        'type' => 'select regency',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => false,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f5a2',
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Apa jenis perusahaan/instansi/institusi tempat Anda bekerja sekarang?',
                                'code' => 'F11',
                                'hint' => null,
                                'type' => 'multiple choice',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f11',
                                'options' => [
                                    [
                                        'text' => 'Instansi Pemerintah',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'BUMN/BUMD',
                                        'value' => 6
                                    ],
                                    [
                                        'text' => 'Institusi/Organisasi Multilateral',
                                        'value' => 7
                                    ],
                                    [
                                        'text' => 'Organisasi non-profit/Lembaga Swadaya Masyarakat',
                                        'value' => 2
                                    ],
                                    [
                                        'text' => 'Perusahaan Swasta',
                                        'value' => 3
                                    ],
                                    [
                                        'text' => 'Wiraswasta/Perusahaan Sendiri',
                                        'value' => 4
                                    ],
                                    [
                                        'text' => 'Lainnya, tuliskan:',
                                        'is_custom_value' => true,
                                        'value' => '0'
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Apa nama perusahaan/kantor tempat Anda bekerja?',
                                'code' => 'F5-B',
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f5b',
                            ],
                            [
                                'text' => 'Bila berwiraswasta, apa posisi/jabatan Anda saat ini ?',
                                'code' => 'F5-C',
                                'hint' => null,
                                'type' => 'dropdown',
                                'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f5c',
                                'options' => [
                                    [
                                        'text' => 'Founder',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'Co-Founder',
                                        'value' => 2
                                    ],
                                    [
                                        'text' => 'Staff',
                                        'value' => 3
                                    ],
                                    [
                                        'text' => 'Freelance / Kerja Lepas',
                                        'value' => 4
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Apa tingkat tempat kerja Anda?',
                                'code' => 'F5-D',
                                'hint' => null,
                                'type' => 'dropdown',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f5d',
                                'options' => [
                                    [
                                        'text' => 'Lokal/Wilayah/Wiraswasta tidak Berbadan Hukum',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'Nasional/Wiraswasta Berbadan Hukum',
                                        'value' => 2
                                    ],
                                    [
                                        'text' => 'Multinasional/Internasional',
                                        'value' => 3
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Sebutkan sumber biaya untuk melanjutkan studi?',
                                'code' => 'F18-A',
                                'hint' => null,
                                'type' => 'dropdown',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f18a',
                                'options' => [
                                    [
                                        'text' => 'Biaya Sendiri',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'Beasiswa',
                                        'value' => 2
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Melanjutkan studi di Perguruan Tinggi mana?',
                                'code' => 'F18-B',
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f18b',
                            ],
                            [
                                'text' => 'Melanjutkan studi pada Program Studi apa?',
                                'code' => 'F18-C',
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f18c',
                            ],
                            [
                                'text' => 'Masuk ke Perguruan Tinggi tersebut pada tanggal?',
                                'code' => 'F18-D',
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f18d',
                            ],
                            [
                                'text' => 'Sebutkan sumberdana dalam pembiayaan kuliah? (bukan ketika Studi Lanjut)',
                                'code' => 'F12',
                                'hint' => null,
                                'type' => 'multiple choice',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f12',
                                'options' => [
                                    [
                                        'text' => 'Biaya Sendiri / Keluarga',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'Beasiswa ADIK',
                                        'value' => 2
                                    ],
                                    [
                                        'text' => 'Beasiswa BIDIKMISI',
                                        'value' => 3
                                    ],
                                    [
                                        'text' => 'Beasiswa PPA',
                                        'value' => 4
                                    ],
                                    [
                                        'text' => 'Beasiswa AFIRMASI',
                                        'value' => 5
                                    ],
                                    [
                                        'text' => 'Beasiswa Perusahaan/Swasta',
                                        'value' => 6
                                    ],
                                    [
                                        'text' => 'Lainnya, tuliskan:',
                                        'is_custom_value' => true,
                                        'value' => '0',
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Seberapa erat hubungan antara bidang studi dengan pekerjaan anda?',
                                'code' => 'F14',
                                'hint' => null,
                                'type' => 'multiple choice',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f14',
                                'options' => [
                                    [
                                        'text' => 'Sangat Erat',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'Erat',
                                        'value' => 2
                                    ],
                                    [
                                        'text' => 'Cukup Erat',
                                        'value' => 3
                                    ],
                                    [
                                        'text' => 'Kurang Erat',
                                        'value' => 4
                                    ],
                                    [
                                        'text' => 'Tidak Sama Sekali',
                                        'value' => 5
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Tingkat pendidikan apa yang paling tepat/sesuai untuk pekerjaan anda saat ini?',
                                'code' => 'F15',
                                'hint' => null,
                                'type' => 'multiple choice',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f15',
                                'options' => [
                                    [
                                        'text' => 'Setingkat Lebih Tinggi',
                                        'value' => 1
                                    ],
                                    [
                                        'text' => 'Tingkat yang Sama',
                                        'value' => 2
                                    ],
                                    [
                                        'text' => 'Setingkat Lebih Rendah',
                                        'value' => 3
                                    ],
                                    [
                                        'text' => 'Tidak Perlu Pendidikan Tinggi',
                                        'value' => 4
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Pada saat lulus, pada tingkat mana kompetensi di bawah ini anda kuasai?',
                                'code' => 'F17',
                                'hint' => null,
                                'type' => 'multiple question',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => true,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                'question_childs' => [
                                    [
                                        'text' => 'Etika',
                                        'code' => 'F17-61',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1761',
                                    ],
                                    [
                                        'text' => 'Keahlian berdasarkan Bidang Ilmu',
                                        'code' => 'F17-63',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1763',
                                    ],
                                    [
                                        'text' => 'Bahasa Inggris',
                                        'code' => 'F17-65',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1765',
                                    ],
                                    [
                                        'text' => 'Penggunaan Teknologi Informasi',
                                        'code' => 'F17-67',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1767',
                                    ],
                                    [
                                        'text' => 'Komunikasi',
                                        'code' => 'F17-69',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1769',
                                    ],
                                    [
                                        'text' => 'Kerjasama Tim',
                                        'code' => 'F17-71',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1771',
                                    ],
                                    [
                                        'text' => 'Pengembangan Diri',
                                        'code' => 'F17-73',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1773',
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Pada saat ini, pada tingkat mana kompetensi di bawah ini diperlukan dalam pekerjaan?',
                                'code' => 'F17-b',
                                'hint' => null,
                                'type' => 'multiple question',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => true,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                'question_childs' => [
                                    [
                                        'text' => 'Etika',
                                        'code' => 'F17-62',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1762',
                                    ],
                                    [
                                        'text' => 'Keahlian berdasarkan Bidang Ilmu',
                                        'code' => 'F17-64',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1763',
                                    ],
                                    [
                                        'text' => 'Bahasa Inggris',
                                        'code' => 'F17-66',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1766',
                                    ],
                                    [
                                        'text' => 'Penggunaan Teknologi Informasi',
                                        'code' => 'F17-68',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1768',
                                    ],
                                    [
                                        'text' => 'Komunikasi',
                                        'code' => 'F17-70',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1770',
                                    ],
                                    [
                                        'text' => 'Kerjasama Tim',
                                        'code' => 'F17-72',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1772',
                                    ],
                                    [
                                        'text' => 'Pengembangan Diri',
                                        'code' => 'F17-74',
                                        'hint' => null,
                                        'type' => 'rating',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f1774',
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'title' => 'Kuisioner Opsional',
                        'description' => null,
                        'questions' => [
                            [
                                'text' => 'Menurut anda seberapa besar penekanan pada metode pembelajaran di bawah ini dilaksanakan di program studi anda?',
                                'code' => 'F2',
                                'hint' => null,
                                'type' => 'multiple question',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => true,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                'question_childs' => [
                                    [
                                        'text' => 'Perkuliahan',
                                        'code' => 'F2-1',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f21',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                    [
                                        'text' => 'Demonstrasi',
                                        'code' => 'F2-2',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f22',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                    [
                                        'text' => 'Partisipasi dalam Proyek Riset',
                                        'code' => 'F2-3',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f23',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                    [
                                        'text' => 'Magang',
                                        'code' => 'F2-4',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f24',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                    [
                                        'text' => 'Praktikum',
                                        'code' => 'F2-5',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f25',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                    [
                                        'text' => 'Kerja Lapangan',
                                        'code' => 'F2-6',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f26',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                    [
                                        'text' => 'Diskusi',
                                        'code' => 'F2-7',
                                        'hint' => null,
                                        'type' => 'multiple choice',
                                        // 'is_required' => false,
                                        'default_value' => null,
                                        'is_default_value_editable' => null,
                                        // 'is_displayed_from_start' => true,
                                        'parent_id' => null,
                                        // 'default_next_question_id' => null,
                                        // 'is_exportable' => true,
                                        // 'export_code' => 'f27',
                                        'options' => [
                                            [
                                                'text' => 'Sangat Besar',
                                                'value' => 1,
                                            ],
                                            [
                                                'text' => 'Besar',
                                                'value' => 2,
                                            ],
                                            [
                                                'text' => 'Cukup Besar',
                                                'value' => 3,
                                            ],
                                            [
                                                'text' => 'Kurang',
                                                'value' => 4,
                                            ],
                                            [
                                                'text' => 'Tidak Sama Sekali',
                                                'value' => 5,
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                            [
                                'text' => 'Kapan anda mulai mencari pekerjaan?',
                                'code' => 'F3-01',
                                'hint' => 'Mohon pekerjaan sambilan tidak dimasukkan',
                                'type' => 'multiple choice',
                                'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => true,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f301',
                                'options' => [
                                    [
                                        'text' => 'Sebelum Lulus',
                                        'value' => 1,
                                        // 'next_question_id' => 'F3-02'
                                    ],
                                    [
                                        'text' => 'Sesudah Lulus',
                                        'value' => 2,
                                        // 'next_question_id' => 'F3-03'
                                    ],
                                    [
                                        'text' => 'Saya tidak mencari kerja',
                                        'value' => 2,
                                    ],
                                ],
                                // 'question_childs' => [
                                //     [
                                //         'text' => 'Kira-kira berapa bulan sebelum lulus?',
                                //         'code' => 'F3-02',
                                //         'hint' => null,
                                //         'type' => 'single-line text',
                                //         // 'is_required' => false,
                                //         'default_value' => null,
                                //         'is_default_value_editable' => null,
                                //         // 'is_displayed_from_start' => false,
                                //         'parent_id' => null,
                                //         // 'default_next_question_id' => null,
                                //         // 'is_exportable' => true,
                                //         // 'export_code' => 'f302',
                                //     ],
                                //     [
                                //         'text' => 'Kira-kira berapa bulan sesudah lulus?',
                                //         'code' => 'F3-03',
                                //         'hint' => null,
                                //         'type' => 'single-line text',
                                //         // 'is_required' => false,
                                //         'default_value' => null,
                                //         'is_default_value_editable' => null,
                                //         // 'is_displayed_from_start' => false,
                                //         'parent_id' => null,
                                //         // 'default_next_question_id' => null,
                                //         // 'is_exportable' => true,
                                //         // 'export_code' => 'f303',
                                //     ]
                                // ]
                            ],
                            [
                                'text' => 'Kira-kira berapa bulan sebelum lulus?',
                                'code' => 'F3-02',
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f302',
                            ],
                            [
                                'text' => 'Kira-kira berapa bulan sesudah lulus?',
                                'code' => 'F3-03',
                                'hint' => null,
                                'type' => 'single-line text',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => false,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => true,
                                // 'export_code' => 'f303',
                            ],
                            [
                                'text' => 'Bagaimana anda mencari pekerjaan tersebut?',
                                'code' => 'F4',
                                'hint' => 'Jawaban bisa lebih dari satu',
                                'type' => 'multiple choice',
                                // 'is_required' => false,
                                'default_value' => null,
                                'is_default_value_editable' => null,
                                // 'is_displayed_from_start' => true,
                                'parent_id' => null,
                                // 'default_next_question_id' => null,
                                // 'is_exportable' => false,
                                // 'export_code' => null,
                                'options' => [
                                    [
                                        'text' => 'Melalui iklan di koran/majalah, brosur ',
                                        'value' => 1,
                                        'code' => 'f4-01'
                                    ],
                                    [
                                        'text' => 'Melamar ke perusahaan tanpa mengetahui lowongan yang ada',
                                        'value' => 1,
                                        'code' => 'f4-02'
                                    ],
                                    [
                                        'text' => 'Pergi ke bursa/pameran kerja',
                                        'value' => 1,
                                        'code' => 'f4-03'
                                    ],
                                    [
                                        'text' => 'Lainnya, tuliskan:',
                                        'value' => '',
                                        'code' => 'f4-15',
                                        'is_custom_value' => true,
                                        'value' => '0'
                                    ],
                                ],
                            ]
                        ]

                    ]

                ]
            ]
        ];

        Schema::disableForeignKeyConstraints();
        QuestionOption::truncate();
        Question::truncate();
        FormSection::truncate();
        Form::truncate();
        Schema::enableForeignKeyConstraints();
        DB::beginTransaction();
        try {
            foreach ($data as $dataRow) {
                $form = Form::firstOrCreate([
                    // 'tag' => $dataRow['tag'],
                    'slug' => $dataRow['slug'],
                    'name' => $dataRow['name'],
                ], [
                    'description' => $dataRow['description']
                ]);
                foreach ($dataRow['sections'] as $keySection => $section) {
                    $formSection = FormSection::firstOrCreate([
                        'form_id' => $form->id,
                        'title' => $section['title'],
                    ], [
                        'description' => $section['description'],
                        'order' => $keySection,
                    ]);
                    foreach ($section['questions'] as $keyQuestion => $question) {
                        $questionNew = Question::firstOrCreate([
                            'form_section_id' => $formSection->id,
                            'text' => $question['text'],
                            'code' => $question['code']
                        ], [
                            'hint' => $question['hint'],
                            'type' => $question['type'],
                            // 'is_required' => $question['is_required'],
                            'default_value' => $question['default_value'],
                            'is_default_value_editable' => $question['is_default_value_editable'],
                            // 'is_displayed_from_start' => isset($question['is_displayed_from_start']) ? $question['is_displayed_from_start'] : true,
                            'parent_id' => null,
                            // 'default_next_question_id' => null,
                            // 'is_exportable' => $question['is_exportable'],
                            // 'export_code' => $question['export_code'],
                            'order' => $keyQuestion,
                        ]);
                        if (isset($question['options']) && !empty($question['options'])) {
                            foreach ($question['options'] as $keyOption => $option) {
                                $questionOption = QuestionOption::firstOrCreate([
                                    'question_id' => $questionNew->id,
                                    'text' => $option['text'],
                                ], [
                                    'hint' => @$option['hint'],
                                    'value' => @$option['value'],
                                    'is_custom_value' => isset($option['is_custom_value']) ?  $option['is_custom_value'] : false,
                                    'order' => isset($option['order']) ? $option['order'] : 0,
                                    'code' => @$option['code'],
                                    // 'export_code' => @$option['export_code'],
                                    // 'next_question_id' => @$option['next_question_id'],
                                    'order' => $keyOption,
                                ]);
                            }
                        }
                        if (isset($question['question_childs']) && !empty($question['question_childs'])) {
                            foreach ($question['question_childs'] as $keyQuestionChild => $questionChild) {
                                $questionChildNew = Question::firstOrCreate([
                                    'form_section_id' => $formSection->id,
                                    'parent_id' => $questionNew->id,
                                    'text' => $questionChild['text'],
                                    'code' => $questionChild['code'],
                                ], [
                                    'hint' => $questionChild['hint'],
                                    'type' => $questionChild['type'],
                                    // 'is_required' => $questionChild['is_required'],
                                    'default_value' => $questionChild['default_value'],
                                    'is_default_value_editable' => $questionChild['is_default_value_editable'],
                                    // 'is_displayed_from_start' => isset($questionChild['is_displayed_from_start']) ? $questionChild['is_displayed_from_start'] : true,
                                    // 'default_next_question_id' => null,
                                    // 'is_exportable' => $questionChild['is_exportable'],
                                    // 'export_code' => $questionChild['export_code'],
                                    'order' => $keyQuestionChild,
                                ]);
                                if (isset($questionChild['options']) && !empty($questionChild['options'])) {
                                    // var_dump($questionChild['options']);
                                    foreach ($questionChild['options'] as $keyQuestionChildOption => $questionChildOption) {
                                        $questionChildOption = QuestionOption::firstOrCreate([
                                            'question_id' => $questionChildNew->id,
                                            'text' => $questionChildOption['text'],
                                        ], [
                                            'hint' => @$questionChildOption['hint'],
                                            'value' => @$questionChildOption['value'],
                                            'is_custom_value' => isset($questionChildOption['is_custom_value']) ?  $questionChildOption['is_custom_value'] : false,
                                            'order' => isset($questionChildOption['order']) ? $questionChildOption['order'] : 0,
                                            'code' => @$questionChildOption['code'],
                                            // 'export_code' => @$questionChildOption['export_code'],
                                            // 'next_question_id' => @$questionChildOption['next_question_id'],
                                            'order' => $keyQuestionChildOption,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
