<?php

// Function to add a search query to recent searches
function add_recent_search($query)
{
    // Trim the search query to remove leading and trailing spaces
    $query = trim($query);

    // Check if the query is not empty
    if (!empty($query)) {
        $recent_searches = get_option('recent_searches', array());

        // Remove any existing occurrences of the query
        $recent_searches = array_diff($recent_searches, array($query));

        // Add the query to the beginning of the array
        array_unshift($recent_searches, $query);

        // Limit the number of recent searches, adjust as needed
        $max_recent_searches = 6;

        // Trim the array to the maximum allowed size
        $recent_searches = array_slice($recent_searches, 0, $max_recent_searches);

        // Update the option
        update_option('recent_searches', $recent_searches);
    }
}

// Function to get recent searches
function get_recent_searches()
{
    return get_option('recent_searches', array());
}

// Call add_recent_search whenever a search is performed
if (isset($_GET['s'])) {
    $search_query = sanitize_text_field($_GET['s']);
    add_recent_search($search_query);
}

// AJAX handler to clear search history
function clear_search_history()
{
    delete_option('recent_searches');
    wp_send_json_success();
}
add_action('wp_ajax_clear_search_history', 'clear_search_history');
