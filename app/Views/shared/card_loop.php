<?php
// PUBLIC PROFILE //
/* BURASI SADECE HERKESE AÇIK GÖRÜNÜR PROFİL SAYFASINDA ÇALIŞIR*/
if (!empty($card_data['userIconAddress'])) {
    echo '<div class="d-flex align-items-center p-3 my-3 mt-5 text-white-50 bg-purple rounded shadow-sm">
    <img class="mr-3" src="' . $card_data['userIconAddress'] . '" alt="" width="48" height="48">
    <div class="lh-100">
        <h6 class="mb-0 text-white lh-100">' . $card_data['fullName'] . '</h6>
        <small>' . lang('View.shared.card_loop.ifPublicUserPage') . '</small>
    </div>
</div>';
}
// PUBLIC PROFILE END //
?>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <?php

            if (!empty($card_data['contentSummary'])) {
                foreach ($card_data['contentSummary'] as $value) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-4 shadow-sm bg-light">
                      <img class="card-img-top" src="' . $value['publicTitleImageAddress']['title'] . '" style="height: 225px">
                            <div class="card-body">
                                <p class="card-text text-truncate">' . $value['title'] . '</p>
                                <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button"' . $value['viewButtonLink'] . ' class="btn btn-sm btn-outline-secondary">' . lang('View.shared.card_loop.show') . '</button>';
                    if (!empty($value['editable'])) {
                        echo '<button type="button" ' . $value['editButtonLink'] . 'class="btn btn-sm btn-outline-secondary">' . lang('View.shared.card_loop.edit') . '</button>';
                        if (!empty($value['segment']['dashboard'])) {
                            echo '<button type="button"' . $value['deleteButtonLink'] . 'class="btn btn-sm btn-outline-secondary">' . lang('View.shared.card_loop.delete') . '</button>';
                        }

                        echo '</div>
                    <small class="text-muted text-right text-truncate ml-2">' . $value['createdAt'] . '</small>';
                    } else {
                        echo '</div>';
                    }

                    echo '</div>
                    </div>
                </div>';
                    echo '</div>';
                }
                unset($ConstantForLoop);
            } else {
                echo '<h2>' . lang('View.shared.card_loop.notHaveThings') . '</h2>';
            }


            ?>
        </div>
    </div>
</div>

