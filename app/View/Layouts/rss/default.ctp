<?php 
/**
 * layout for RSS feed
 */
if (!isset($documentData)) {
    $documentData = array();
}
if (!isset($channelData)) {
    $channelData = array();
}
if (!isset($channelData['title'])) {
    $channelData['title'] = $title_for_layout;
}

$channel = $this->Rss->channel(array(), $channelData, $items);
echo $this->Rss->document($channel);
?>