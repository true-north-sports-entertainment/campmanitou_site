<?php
/* Filter the content of chat posts. */
add_filter( 'the_content', 'bf_format_chat_content' );

/**
 * This function filters the post content when viewing a post with the "chat" post format.
 *
 * @author BetterStudio
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $content The content of the post.
 * @return string $chat_output The formatted content of the post.
 */
function bf_format_chat_content( $content ) {
    global $_bf_post_format_chat_ids;

    /* If this is not a 'chat' post, return the content. */
    if ( !has_post_format( 'chat' ) )
        return $content;

    $_bf_post_format_chat_ids = array();

    $separator = apply_filters( 'better-framework/chat-format/separator', ' :' );

    $chat_output = '<ul class="chat">';

    /* Split the content to get individual chat rows. */
    $chat_rows = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", $content );

    foreach ( $chat_rows as $chat_row ) {

        if ( strpos( $chat_row, $separator ) ) {

            $chat_row_split = explode( $separator, trim( $chat_row ), 2 );

            $chat_author = strip_tags( trim( $chat_row_split[0] ) );

            $chat_text = trim( $chat_row_split[1] );

            $speaker_id = hf_format_chat_row_id( $chat_author );

            $chat_output .= '<li class="user_' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

            $chat_output .= '<span class="label">' . apply_filters( 'better-framework/chat-format/author', $chat_author, $speaker_id ) . ' : </span>';

            $chat_output .= str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'better-framework/chat-format/text', $chat_text, $chat_author, $speaker_id ) );

            $chat_output .= "\n\t\t\t\t" . '</li>';
        }

        /**
         * If no author is found, assume this is a separate paragraph of text that belongs to the
         * previous speaker and label it as such, but let's still create a new row.
         */
        else {
            if ( !empty( $chat_row ) ) {
                $chat_output .= '<li class="user_' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';
                $chat_output .= str_replace( array( "\r", "\n", "\t" ), '', apply_filters( 'better-framework/chat-format/text', $chat_row, $chat_author, $speaker_id ) );
                $chat_output .= "</li>";
            }
        }
    }

    $chat_output .= "</ul>";

    return apply_filters( 'better-framework/chat-format/content', $chat_output );
}

/**
 * This function returns an ID based on the provided chat author name.
 *
 * @author BetterStudio
 *
 * @global array $_post_format_chat_ids An array of IDs for the chat rows based on the author.
 * @param string $chat_author Author of the current chat row.
 * @return int The ID for the chat row based on the author.
 */
function bf_format_chat_row_id( $chat_author ) {
    global $_bf_post_format_chat_ids;
    $chat_author = strtolower( strip_tags( $chat_author ) );
    $_bf_post_format_chat_ids[] = $chat_author;
    $_bf_post_format_chat_ids = array_unique( $_bf_post_format_chat_ids );
    return absint( array_search( $chat_author, $_bf_post_format_chat_ids ) ) + 1;
}


