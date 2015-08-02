<?php
/**
 * Method to make the rss
 * @params array
 * @return array
 */
//include appcontroller class
App::uses('Controller', 'AppController');

/**
 * Making the Rss feed content
 * @param array $item
 * @return multitype:string multitype:string NULL
 */
function transformRss($item) 
{
	$forum_page_url = getforumlinks($item['Forum']['contentpage_id']);
	$post_type = ($item['Forum']['post_type']) ? 'RE: ': '';
	return array('title' => ucfirst($item['Forum']['user_coursename']).'-'.$item['Forum']['user_sectionname'].' - '.$post_type.ucfirst($item['Forum']['post_subject']).' posted by '.ucfirst($item['Forum']['post_by']),
		'link' => $forum_page_url,
		'guid' => array('controller' => 'posts', 'action' => 'logOut', $item['Forum']['id']),
		'description' => strip_tags(substr(ucfirst(trim($item['Forum']['post_body'])), 0, 100).'....'),
		'author' => ucfirst($item['Forum']['post_by']),
		'pubDate' => date('d-m-Y h:i A', $item['Forum']['post_date']),	
	);
}

/**
 * Finding the forum page link
 * @param int $content_page_id
 * @return string
 */
function getforumlinks($content_page_id)
{
	$link = AppController::getForumPageLink($content_page_id);
	return $link;
}
//making the rss feed of posts coming from posts controller.
$this->set('items', $this->Rss->items($posts, 'transformRss'));
//$this->set('channelData', $channelData);
?>