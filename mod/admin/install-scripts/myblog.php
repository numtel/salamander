<? 
$install['Example Blog Data']=function($node){

//pattern
if(!$node->record_tree2->insert('/patterns/',array (
  'blog' => array (
    'label' => 'Simple Blog',
    'node:children' => array (
      'category' => array (
        'label' => 'Category',
        'type' => 'recursive',
        'recursive-level' => 'true',
        'node:children' => array (
          'title' => array (
            'label' => 'Title',
          ),
        ),
      ),
      'post' => array (
        'label' => 'Post',
        'type' => 'array',
        'set-permission' => '0:5',
        'node:children' => array (
          'title' => array (
            'label' => 'Title',
          ),
          'content' =>  array (
            'label' => 'Content',
            'type' => 'richtext',
          ),
          'comment' => array (
            'label' => 'Comments',
            'type' => 'array',
            'enable-insert' => '0',
            'node:children' => array (
              'comment' => array (
                'label' => 'Comment',
                'type' => 'textarea',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
))) return 'Install Failure: Count not insert example blog pattern.';

//sample posts
require('lib/LoremIpsum.class.php');
$gen = new LoremIpsumGenerator;
$posts=array();
for($i=0;$i<30;++$i){
   $posts['post-'.$i.'-'.random_string()]=array(
	  'pattern:match'=>'/patterns/blog/post',
      'title'=>$gen->getContent(mt_rand(4,15)),
      'content'=>$gen->getContent(mt_rand(40,150)));
}
if(!$node->record_tree2->insert('/',array('myblog'=>
   array('pattern:children'=>'/patterns/blog/',
         'admin:icon'=>'book',
         'node:children'=>array('gen'=>array('pattern:match'=>'/patterns/blog/category',
						         'title'=>'Testing',
						         'node:children'=>$posts)))))) 
	return 'Install Failure: Could not insert sample blog data.';
return true;

};

