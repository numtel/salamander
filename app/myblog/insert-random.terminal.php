<?//copy+pasta into terminal for 30 blog posts inserted into category at /myblog/gen/
require('lib/LoremIpsum.class.php');$gen = new LoremIpsumGenerator;for($i=0;$i<30;++$i){$node->record_tree2->insert('/myblog/gen/',array('post-#RAND#'=>array('pattern:match'=>'/patterns/blog/post','title'=>$gen->getContent(mt_rand(4,15)),'content'=>$gen->getContent(100))));}

