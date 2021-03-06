<div class="row justify-content-center">
    <div class="col-xl-12 mb-4 text-center mt-3">
        <a href="javascript::void(0)" class="btn btn-outline-primary btn-rounded btn-sm ml-1" onclick="showAjaxModal('<?php echo site_url('modal/popup/section_add/'.$course_id); ?>', '<?php echo get_phrase('add_new_section'); ?>')"><i class="mdi mdi-plus"></i> <?php echo get_phrase('add_section'); ?></a>
        <a href="javascript::void(0)" class="btn btn-outline-primary btn-rounded btn-sm ml-1" onclick="showAjaxModal('<?php echo site_url('modal/popup/lesson_add/'.$course_id); ?>', '<?php echo get_phrase('add_new_lesson'); ?>')"><i class="mdi mdi-plus"></i> <?php echo get_phrase('add_lesson'); ?></a>
        <a href="javascript::void(0)" class="btn btn-outline-primary btn-rounded btn-sm ml-1" onclick="showAjaxModal('<?php echo site_url('modal/popup/evaluation_add/'.$course_id); ?>', '<?php echo get_phrase('add_evaluation_written'); ?>')"><i class="mdi mdi-plus"></i> <?php echo get_phrase('add_evaluation_written'); ?></a>
        <a href="javascript::void(0)" class="btn btn-outline-primary btn-rounded btn-sm ml-1" onclick="showAjaxModal('<?php echo site_url('modal/popup/quiz_add/'.$course_id); ?>', '<?php echo get_phrase('add_evaluation_objective'); ?>')"><i class="mdi mdi-plus"></i> <?php echo get_phrase('add_evaluation_objective'); ?></a>
        <a href="javascript::void(0)" class="btn btn-outline-primary btn-rounded btn-sm ml-1" onclick="showLargeModal('<?php echo site_url('modal/popup/sort_section/'.$course_id); ?>', '<?php echo get_phrase('sort_sections'); ?>')"><i class="mdi mdi-sort-variant"></i> <?php echo get_phrase('sort_sections'); ?></a>
    </div>

    <div class="col-xl-8">
        <div class="row">
            <?php
            $lesson_counter = 0;
            $quiz_counter   = 0;
            $sections = $this->crud_model->get_section('course', $course_id)->result_array();
            foreach ($sections as $key => $section):?>
            <div class="col-xl-12">
                <div class="card bg-light text-seconday on-hover-action mb-5" id = "section-<?php echo $section['id']; ?>">
                    <div class="card-body">
                        <h5 class="card-title" class="mb-3" style="min-height: 35px;"><span class="font-weight-light"><?php echo get_phrase('section').' '.++$key; ?></span>: <?php echo $section['title']; ?>
                            <div class="row justify-content-center alignToTitle float-right display-none" id = "widgets-of-section-<?php echo $section['id']; ?>">
                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm" name="button" onclick="showLargeModal('<?php echo site_url('modal/popup/sort_lesson/'.$section['id']); ?>', '<?php echo get_phrase('sort_lessons'); ?>')" ><i class="mdi mdi-sort-variant"></i> <?php echo get_phrase('sort_lesson'); ?></button>
                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm ml-1" name="button" onclick="showAjaxModal('<?php echo site_url('modal/popup/section_edit/'.$section['id'].'/'.$course_id); ?>', '<?php echo get_phrase('update_section'); ?>')" ><i class="mdi mdi-pencil-outline"></i> <?php echo get_phrase('edit_section'); ?></button>
                                <button type="button" class="btn btn-outline-secondary btn-rounded btn-sm ml-1" name="button" onclick="confirm_modal('<?php echo site_url('admin/sections/'.$course_id.'/delete'.'/'.$section['id']); ?>');"><i class="mdi mdi-window-close"></i> <?php echo get_phrase('delete_section'); ?></button>
                            </div>
                        </h5>
                        <div class="clearfix"></div>
                        <?php
                        $lessons = $this->crud_model->get_lessons('section', $section['id'])->result_array();
                        $evaluations = $this->crud_model->get_written_eveluation('section', $section['id'])->result_array();
                        foreach ($lessons as $index => $lesson):?>
                        <div class="col-md-12">
                            <!-- Portlet card -->
                            <div class="card text-secondary on-hover-action mb-2" id = "<?php echo 'lesson-'.$lesson['id']; ?>">
                                <div class="card-body thinner-card-body">
                                    <div class="card-widgets display-none" id = "widgets-of-lesson-<?php echo $lesson['id']; ?>">
                                        <?php if ($lesson['lesson_type'] == 'quiz'): ?>
                                            <a href="javascript::" onclick="showLargeModal('<?php echo site_url('modal/popup/quiz_questions/'.$lesson['id']); ?>', '<?php echo get_phrase('manage_quiz_questions'); ?>')"><i class="mdi mdi-comment-question-outline"></i></a>
                                            <a href="javascript::" onclick="showAjaxModal('<?php echo site_url('modal/popup/quiz_edit/'.$lesson['id'].'/'.$course_id); ?>', '<?php echo get_phrase('update_quiz_information'); ?>')"><i class="mdi mdi-pencil-outline"></i></a>
                                        <?php else: ?>
                                            <a href="javascript::" onclick="showAjaxModal('<?php echo site_url('modal/popup/lesson_edit/'.$lesson['id'].'/'.$course_id); ?>', '<?php echo get_phrase('update_lesson'); ?>')"><i class="mdi mdi-pencil-outline"></i></a>
                                        <?php endif; ?>
                                        <a href="javascript::" onclick="confirm_modal('<?php echo site_url('admin/lessons/'.$course_id.'/delete'.'/'.$lesson['id']); ?>');"><i class="mdi mdi-window-close"></i></a>
                                    </div>
                                    <h5 class="card-title mb-0">
                                        <span class="font-weight-light">
                                            <?php
                                            if ($lesson['lesson_type'] == 'quiz') {
                                                $quiz_counter++; // Keeps track of number of quiz
                                                $lesson_type = $lesson['lesson_type'];
                                            }else {
                                                $lesson_counter++; // Keeps track of number of lesson
                                                if ($lesson['attachment_type'] == 'txt' || $lesson['attachment_type'] == 'pdf' || $lesson['attachment_type'] == 'doc' || $lesson['attachment_type'] == 'img') {
                                                    $lesson_type = $lesson['attachment_type'];
                                                }else {
                                                    $lesson_type = 'video';
                                                }
                                            }
                                            ?>
                                            <img src="<?php echo base_url('assets/backend/lesson_icon/'.$lesson_type.'.png'); ?>" alt="" height = "16">
                                            <?php echo $lesson['lesson_type'] == 'quiz' ? get_phrase('quiz').' '.$quiz_counter : get_phrase('lesson').' '.$lesson_counter; ?>
                                        </span>: <?php echo $lesson['title']; ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <?php foreach($evaluations as $indexs => $evaluation):  ?>
                        <div class="col-md-12">
                            <!-- Portlet card -->
                            <div class="card text-secondary on-hover-action mb-2" id = "<?php echo 'lesson'.'-'.$evaluation['id']; ?>">
                                <div class="card-body thinner-card-body">
                                    <div class="card-widgets display-none" id = "widgets-of-lesson-<?php echo $evaluation['id']; ?>">
                                        <?php if ($evaluation['type'] !== ''): ?>
                                           <a href="javascript::" onclick="showAjaxModal('<?php echo site_url('modal/popup/evaluation_edit/'.$evaluation['id']); ?>', '<?php echo get_phrase('edit_evaluation'); ?>')"><i class="mdi mdi-pencil-outline"></i></a>
                                        <a href="javascript::" onclick="confirm_modal('<?php echo site_url('admin/evaluation/'.$evaluation['id'].'/delete'); ?>');"><i class="mdi mdi-window-close"></i></a>
                                        <?php endif; ?>
                                    </div>
                                    <h5 class="card-title mb-0">
                                        <span class="font-weight-light">
                                            <?php
                                             if ($evaluation['type'] == 'quiz'){
                                              $quiz_counter++; // Keeps track of number of quiz
                                              $lesson_type = $evaluation['lesson_type'];
                                            }else {
                                                $lesson_counter++; // Keeps track of number of lesson
                                            if ($evaluation['attachment_type'] == 'txt' || $evaluation['attachment_type'] == 'pdf' || $evaluation['attachment_type'] == 'doc' || $evaluation['attachment_type'] == 'img') {
                                        $lesson_type = $evaluation['attachment_type'];
                                                }else {
                                                    $lesson_type = 'video';
                                                }
                                            }
                                            ?>
                                            <img src="<?php echo base_url('assets/backend/lesson_icon/'.$lesson_type.'.png'); ?>" alt="" height = "16">
                                            <?php echo $evaluation['lesson_type'] == 'quiz' ? get_phrase('quiz').' '.$quiz_counter : get_phrase('lesson').' '.$lesson_counter; ?>
                                        </span>: <?php echo $evaluation['evaluation_tittle']; ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div> <!-- end card-->
        </div>
    <?php endforeach; ?>
</div>
</div>
</div>
