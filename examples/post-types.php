<?php

$postType = tr_post_type( 'Note' );

$detailsMetabox = tr_meta_box( 'Note Details' );
$postType->addMetaBox( $detailsMetabox );

$detailsMetabox->setCallback( function () {
    $form = tr_form( 'post' );

    $form->text( 'Note Details' );
} );
