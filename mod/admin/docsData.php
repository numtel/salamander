<? $docsPattern=array('patterns'=>array (
  'documentation' => 
  array (
    'label' => 'Documentation Site',
    'node:owner' => '1',
    'node:children' => 
    array (
      'page' => 
      array (
        'type' => 'recursive',
        'node:owner' => '1',
        'node:children' => 
        array (
          'title' => 
          array (
            'label' => 'Title',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'wrapper-element' => 'h1',
            'wrapper-element-class' => 'padding-vertical',
            'no-wrapper-on-page' => '/patterns/documentation',
            'display-as-link' => '/patterns/documentation',
          ),
          'description' => 
          array (
            'label' => 'Description',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'type' => 'textarea',
            'hide-on-page' => '/patterns/documentation/page',
          ),
          'content' => 
          array (
            'type' => 'richtext',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'label' => 'Content',
            'hide-on-page' => '/patterns/documentation',
          ),
          'section' => 
          array (
            'type' => 'recursive',
            'node:owner' => '1',
            'node:children' => 
            array (
              'title' => 
              array (
                'wrapper-element' => 'h2',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'label' => 'Title',
              ),
              'section' => 
              array (
                'label' => 'Content',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'type' => 'richtext',
              ),
            ),
            'label' => 'Section',
            'hide-on-page' => '/patterns/documentation',
          ),
          'hide-menu' => 
          array (
            'label' => 'Hide Dropdown Menu on Frontend',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'type' => 'checkbox',
            'hide-on-page' => '/patterns/documentation,/patterns/documentation/page',
          ),
        ),
        'label' => 'Page',
        'page-read-depth' => '5',
        'hide-on-page' => '/patterns/documentation/page',
      ),
      'module-list' => 
      array (
        'type' => 'array',
        'node:owner' => '1',
        'node:children' => 
        array (
          'module' => 
          array (
            'label' => 'Module Documentation',
            'node:owner' => '1',
            'node:children' => 
            array (
              'name' => 
              array (
                'label' => 'Class',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'display-as-link' => '/patterns/documentation,/patterns/documentation/module-list',
              ),
              'description' => 
              array (
                'type' => 'textarea',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'label' => 'Description',
              ),
              'function' => 
              array (
                'type' => 'array',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'name' => 
                  array (
                    'display-as-link' => '/patterns/documentation/module-list/module',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'label' => 'Name',
                  ),
                  'description' => 
                  array (
                    'type' => 'richtext',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'label' => 'Description',
                  ),
                  'return' => 
                  array (
                    'label' => 'Return Value',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                  ),
                  'parameter' => 
                  array (
                    'type' => 'array',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                      'name' => 
                      array (
                        'label' => 'Variable Name',
                        'node:owner' => '1',
                        'node:children' => 
                        array (
                        ),
                      ),
                      'type' => 
                      array (
                        'label' => 'Data Type',
                        'node:owner' => '1',
                        'node:children' => 
                        array (
                        ),
                      ),
                      'description' => 
                      array (
                        'type' => 'richtext',
                        'node:owner' => '1',
                        'node:children' => 
                        array (
                        ),
                        'label' => 'Description',
                      ),
                    ),
                    'label' => 'Parameter',
                    'set-permission' => '0:1',
                    'enable-insert' => '-101',
                  ),
                  'example' => 
                  array (
                    'type' => 'array',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                      'description' => 
                      array (
                        'label' => 'Description',
                        'node:owner' => '1',
                        'node:children' => 
                        array (
                        ),
                      ),
                      'code' => 
                      array (
                        'label' => 'Code',
                        'node:owner' => '1',
                        'node:children' => 
                        array (
                        ),
                        'type' => 'textarea',
                      ),
                    ),
                    'label' => 'Example',
                    'set-permission' => '0:1',
                    'enable-insert' => '-101',
                  ),
                  'comment' => 
                  array (
                    'type' => 'recursive',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                      'comment' => 
                      array (
                        'label' => 'Comment',
                        'node:owner' => '1',
                        'node:children' => 
                        array (
                        ),
                        'type' => 'textarea',
                        'min-length' => '5',
                        'max-length' => '100000',
                      ),
                    ),
                    'label' => 'Comment',
                    'enable-insert' => '0',
                  ),
                ),
                'label' => 'Function',
                'page-read-depth' => '5',
                'set-permission' => '0:5',
              ),
            ),
            'page-read-depth' => '1',
            'type' => 'array',
          ),
          'title' => 
          array (
            'display-as-link' => '/patterns/documentation',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'label' => 'Title',
          ),
          'description' => 
          array (
            'label' => 'Description',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'type' => 'textarea',
          ),
        ),
        'page-read-depth' => '1',
        'label' => 'Module List',
      ),
    ),
    'page-read-depth' => '1',
  ),
));

$docsData=array (
  'docs' => 
  array (
    'pattern:children' => '/patterns/documentation/',
    'node:owner' => '1',
    'node:children' => 
    array (
      'overview' => 
      array (
        'hide-menu' => '1',
        'node:owner' => '1',
        'node:children' => 
        array (
          'gqstscuuoj' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Directory Structure',
            'section' => '<p>
	URL routing takes place very simply based on the directory structure inside of the template directory.</p>
<p>
	&nbsp;</p>
<pre>
Directory/Directory/Template/Parameter/Parameter?QueryOptional=Bar</pre>
<p>
	The Node object determines which page to display and places the data as the $node-&gt;page array. The render_haml module loads this information to actually display the page.</p>
',
          ),
          'models' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Models',
            'section' => '<p>
	Specify hierarchical models of data patterns for which to validate inserted data. The pattern array below defines for the module documentation on this site. These outlines create rules for data manipulation in parts of the data tree while being parts of the data tree themselves.&nbsp;<a href="%%toroot%%modules/tree_pattern">More information on the tree_pattern module</a></p>
<pre class="code">
Array(
&nbsp; &nbsp; [module] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Module Documentation
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [page-read-depth] =&gt; 1
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; array
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [node:children] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [name] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Class
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [display-as-link] =&gt; /patterns/documentation,/patterns/documentation/module-list
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [description] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; textarea
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Description
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [function] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Function
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [page-read-depth] =&gt; 5
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; array
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [node:children] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [name] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [display-as-link] =&gt; /patterns/documentation/module-list/module
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Name
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [description] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; richtext
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Description
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [return] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Return Value
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [parameter] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; array
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Parameter
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [node:children] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [name] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Variable Name
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Data Type
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [description] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; richtext
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Description
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [example] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Example
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; array
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [node:children] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [description] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Description
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [code] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Code
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; textarea
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [comment] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Comment
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; recursive
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [node:children] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [comment] =&gt; Array(
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [label] =&gt; Comment
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; [type] =&gt; textarea
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )
&nbsp; &nbsp; &nbsp; &nbsp; )
)
&nbsp;
</pre>
',
          ),
          'operations' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Operations',
            'section' => '<p>
	Operations on data are all validated based on data patterns and access rules which can be defined in the shell. Read, write, insert, delete, move, sort, set owner and set permissions rules can be placed on users, groups, all users and the entire world. Each item has an owner that has full permissions to that item and its children. Administrators naturally have ownership permission on the root, allowing full access.</p>
<p>
	Learn more about <a href="%%toroot%%config">how to configure which operations to allow</a> and <a href="%%toroot%%shell">how to use the shell</a>.</p>
',
          ),
          'views' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Views',
            'section' => '<p>
	Code views using HAML (thanks to Google&#39;s pHAMLp) or HTML without having to worry about writing any controller code. The operation is all taking place in a module. Of course, controller files can be placed alongside a view for extra manipulation. Getting started writing less HTML and CSS is easy now, <a href="%%toroot%%haml-sass">learn how to use HAML and SCSS</a> to speed up front end coding.</p>
<pre class="code">
&lt;form method=&quot;post&quot;&gt;
&lt;input name=&quot;action&quot; type=&quot;hidden&quot; value=&quot;record_tree2/edit&quot;&gt;
&lt;input name=&quot;fields[address]&quot; type=&quot;hidden&quot; value=&quot;theData/someItem/myChild&quot;&gt;
&lt;input name=&quot;fields[data][pattern:match]&quot; type=&quot;hidden&quot; value=&quot;/patterns/items/children&quot;&gt;
&lt;textarea name=&quot;fields[data][comment]&quot;&gt;&lt;/textarea&gt;
&lt;button type=&quot;submit&quot;&gt;Edit Item&lt;/button&gt;
&lt;/form&gt;
</pre>
',
          ),
          'events' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Events',
            'section' => '<p>
	Events can be bound to your data tree using a simple query. <a href="%%toroot%%modules/record_tree2/bind">Learn more about events on the bind documentation page.</a></p>
<pre class="code">
//WIERD EXAMPLE:
//make items with attribute &#39;admin:locked&#39; set to true unable to be written in your home directory
$this-&gt;tree-&gt;bind(&quot;~/node:wild-recursive-or-nothing/node:attributes(`admin:locked`=&#39;true&#39;)&quot;, &#39;wsim&#39;, &#39;validate&#39;, function($address,$node,$curItem,$data){
	return false;
});
&nbsp;
&nbsp;
//WIERD EXAMPLE:
//dont allow nodes to be started with horse
$this-&gt;tree-&gt;bind(&#39;~/node:starts-with(horse)&#39;,&#39;wsim&#39;,&#39;validate&#39;,function($address,$node,$curItem,$data){
	echo &quot;noooooooo!!!!! &quot;;
	return false;
});
&nbsp;
&nbsp;
//WIERD EXAMPLE:
//Add an edit-count to each user&#39;s home item
$this-&gt;tree-&gt;bind(&#39;~/node:wild-recursive-or-nothing&#39;,&#39;w&#39;,&#39;complete&#39;,function($address,$node){
	//notice the last parameter, true setting to suppress any events while&nbsp;
	//calling tree modification functions while inside an event
	$curHome=pull_item($node-&gt;record_tree2-&gt;get(&#39;~&#39;,false,false,true));
	if($curHome===false) return false;
	//increase edit count of user home being edited
	$curCount=isset($curHome[&#39;admin:edit-count&#39;]) &amp;&amp; is_int($curHome[&#39;admin:edit-count&#39;]*1) ?
	$curHome[&#39;admin:edit-count&#39;]*1 : 0;
	$node-&gt;record_tree2-&gt;edit(&#39;~&#39;,array(&#39;admin:edit-count&#39;=&gt;$curCount+1),true);
});
&nbsp;
</pre>
',
          ),
        ),
        'description' => 'Get started with the basic concepts of the framework',
        'pattern:match' => '/patterns/documentation/page',
        'title' => 'Overview',
        'content' => '<p>
	Building an application with the node php framework is much simpler than a standard MVC framework. By implementing a data tree class on top of MySQL, data is placed in a system that combines a key=&gt;value storage with rule based access control.</p>
<p>
	The scope of this framework is to provide the PHP/MySQL developer with a standard set of tools for user authentication, organized data storage and templating. This leaves only coding front end views using HAML/HTML, SCSS/CSS, and JavaScript.</p>
<p>
	Traditional controllers have been divided into operations, events and post rules. Rules over which operations can be used on given pages can be specified in the configuration files.&nbsp;Events hook application logic directly to the data instead being tied to specific views.</p>
',
      ),
      'config' => 
      array (
        'hide-menu' => '1',
        'node:owner' => '1',
        'node:children' => 
        array (
          'init' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Module Initialization',
            'section' => '<p>
	The<em> [init]</em> section of the config.ini file defines which modules to load. Keys do not matter and even matching keys in different cascading config.ini files will be merged. Modules are loaded with the keys sorted.</p>
<p>
	In this basic root module initialization, the post module loads last due to its key so that it can access any module it would need to make an operational call to.</p>
<pre>
[init]
module[]=&quot;render/haml.php&quot;
module[]=&quot;render/sass.php&quot;
module[]=&quot;render/js.php&quot;
module[]=&quot;record/group.php&quot;
module[]=&quot;user/user.php&quot;
module[]=&quot;record/tree2.php&quot;
module[]=&quot;tree/pattern.php&quot;
module[]=&quot;tree/home.php&quot;
;Special post module that is placed last that checks for form posts
post[]=&quot;render/post.php&quot;
</pre>
',
          ),
          'post' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Form Post Operation Validation',
            'section' => '<p>
	The <em>[post]</em> section of the config.ini file allows form posts to require validation using a module method call as well as individual field and page parameters specified per action.</p>
<p>
	These entries define some allowed actions as well as a check for ownership role on the data root. Each key begins with either &#39;allow&#39; or &#39;check&#39; followed by an identifier. A &#39;check&#39; prefixed key contains a slash delimited string value that starts with the module name, followed by the method name, then any subsequent argument values.</p>
<pre>
[post]
; use an identifier after the allow or check for multiple entries
; No check required for login post so go ahead and allow:
allow_login[]=&quot;user_user/login&quot;
; make sure user is logged in to be able to post data
allow_tree2[]=&quot;record_tree2&quot;
; check if user is has root privileges
check_root_owner[]=&quot;record_tree2/has_role/o/&quot;
allow_root_owner[]=&quot;admin_terminal/command&quot;

;another example
check_admin_admin[]=&quot;user_user/in_group/Administrators&quot;

</pre>
',
          ),
          'db' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Database Configuration',
            'section' => '<p>
	The <em>[db]</em> section of the root config.ini file defines which class to use for the database module and then any parameters it requires.</p>
<p>
	The only module available right now is db_mysql. This class requires all of these fields.</p>
<pre>
[db]
driver=&quot;db/mysql.php&quot;
host=&quot;localhost&quot;
user=&quot;user&quot;
password=&quot;password&quot;
database=&quot;node&quot;
table_prefix=&quot;new_&quot;
</pre>
<p>Additionally, an install parameter can be used to signal modules to create tables:</p>
<pre>
install=true
</pre>
',
          ),
          'path' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Basic Directory Structure',
            'section' => '<p>
	The<em> [path] </em>section of the root config.ini file defines the most basic module loading settings.</p>
<pre>
[path]
modules=&quot;mod/&quot;
module_suffix=&quot;.php&quot;
</pre>
',
          ),
          'front' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Frontend Configuration',
            'section' => '<p>
	The <em>[front]</em> section of the config.ini file determines the general space for frontend variables to be used with modules or within the applications running in templates. Its keys are merged with each cascading config.ini file unless a <code>replace_front=true</code> is encountered, in which the entire section will be replaced.</p>
<p>
	These basic settings are used for the rendering modules.</p>
<pre>
[front]
site_url=&quot;/node/&quot;
template_dir=&quot;./tpl/&quot;
cache_dir=&quot;./cache/&quot;
upload_dir=&quot;cache/uploads/&quot;
page_template=&quot;tpl&quot; ;template filename for page display
default=&quot;index&quot; ;default file in each directory
missing_to_index=true ;send 404 errors to default page instead with all as parameters
error_404=&quot;error&quot; ;page to redirect output from (not used if missing_to_index=true)
js_min=&quot;main.min.js&quot; ;mod/render/js: filename of minified javascript inside the cache_dir
debug_js=true ;mod/render/js: boolean output source js instead of minified
debug_haml=true ;mod/render/haml: boolean output cached haml expanded instead of minified

</pre>
<p>
	Frontend configuration variables can contain tokens to stand in for the following values:</p>
<ul>
	<li>
		<code>#thisdir#</code> - Path to directory including the template directory prefixed</li>
	<li>
		<code>#thistpl#</code> - Path to this directory without the template directory prefixed</li>
	<li>
		<code>#thisuri#</code> - Absolute server URI to this directory</li>
	<li>
		<code>#rooturi#</code> - Absolute server URI the root directory of this framework</li>
</ul>
',
          ),
        ),
        'pattern:match' => '/patterns/documentation/page',
        'title' => 'Configuration',
        'content' => '<p>
	In the same directory as the node.php file, a root config.ini file defines basic site definitions. In each directory inside the template directory, cascading config.ini files can define settings for individual applications.</p>
',
        'description' => 'Loading modules, setting form post rules and specifying frontend variables on your site is made simple using cascading configuration files.',
      ),
      'root-object' => 
      array (
        'pattern:match' => '/patterns/documentation/page',
        'node:owner' => '1',
        'node:children' => 
        array (
          'mbmryyquvw' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Public Members',
            'section' => '<ul>
	<li>
		<strong>query</strong> <em>(Array)</em> - Associative array containing query string parameters (?foo=bar&amp;test=45)</li>
	<li>
		<strong>page[&#39;uri&#39;]</strong> <em>(String)</em> - Path to current template</li>
	<li>
		<strong>page[&#39;params&#39;]</strong> (Array) - URL values after the template address</li>
	<li>
		<strong>ini</strong> <em>(Array)</em> - Associative array of combined ini configuration</li>
	<li>
		<strong>uri</strong> <em>(String)</em> - Section of url after the server address, not including the query string (e.g. for&nbsp;http://localhost/sal/shell/terminal: /sal/shell/terminal)</li>
	<li>
		<strong>http_server</strong> <em>(String)</em> - Address of the server&nbsp;(e.g. for&nbsp;http://localhost/sal/shell/terminal:&nbsp;http://localhost)</li>
	<li>
		<strong>referrer</strong> <em>(String)</em> - Referring URL, will include entire url if foreign, only the section of the url after the server address is included if local</li>
	<li>
		<strong>fs_path</strong> <em>(String)</em> - File system path to the root of the application</li>
	<li>
		<strong>root_http_path</strong> <em>(String)</em> - Path to root of the application, useful for prefixing link href (e.g. for&nbsp;http://localhost/sal/shell/terminal: /sal/)</li>
</ul>
',
          ),
        ),
        'title' => 'Root Object',
        'description' => 'Every application relies on a root object to provide a namespace.',
        'content' => '<p>
	The root object contains the code for determining which page to view, loading applicable configuration files, and loads the used modules.</p>
',
        'hide-menu' => '1',
      ),
      'modules' => 
      array (
        'pattern:match' => '/patterns/documentation/module-list',
        'node:owner' => '1',
        'node:children' => 
        array (
          'db_mysql' => 
          array (
            'name' => 'db_mysql',
            'node:owner' => '1',
            'node:children' => 
            array (
              'count' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'bhfzganxwf' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table_name',
                    'type' => 'String',
                    'description' => '<p>
	Table to grab count from</p>
',
                  ),
                  'zsscgbxtik' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$field',
                    'type' => 'String',
                    'description' => '<p>
	Field name to count or use asterisk for all fields</p>
',
                  ),
                  'fhoykrhgrl' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$where',
                    'type' => 'Array',
                    'description' => '<p>
	Column=&gt;Value pairs to match for count</p>
',
                  ),
                ),
                'name' => 'count($table_name,$field=\'*\',$where=array())',
                'description' => '<p>
	Return the number of items in a table or a field, possibly specifying extra conditions.</p>
',
                'return' => 'Integer on success, False on failure',
              ),
              'delete' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'avwiwnjfkh' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table_name',
                    'type' => 'String',
                    'description' => '<p>
	Table to delete records from</p>
',
                  ),
                  'dqbmiwjcje' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$where',
                    'type' => 'Array',
                    'description' => '<p>
	Column=&gt;Value to match for deleting</p>
',
                  ),
                  'ulmhbczysl' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$reallyDelete',
                    'type' => 'Boolean',
                    'description' => '<p>
	Actually delete the records instead of just changing the `active` column value to 0 (default: false)</p>
',
                  ),
                  'kvpyswojco' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$reallyDeleteVersions',
                    'type' => 'Boolean',
                    'description' => '<p>
	Actually delete any associated versions of this record as well. Requires the record&#39;s id to be specified (default: false)</p>
',
                  ),
                  'qjqcmfzhve' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$limit',
                    'type' => 'String',
                    'description' => '<p>
	Placed after the where clause in the query (could contain &#39;ORDER BY&#39;, &#39;LIMIT&#39;)</p>
',
                  ),
                ),
                'name' => 'delete($table_name,$where,$reallyDelete=false,$reallyDeleteVersions=false,$limit=\'\')',
                'description' => '<p>
	Delete records from a table</p>
',
                'return' => 'True on success, False on failure',
              ),
              'init_table' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'vyukbvxlzm' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$name',
                    'type' => 'String',
                    'description' => '<p>
	Table name to create if not already exists</p>
',
                  ),
                  'dzrdxouzlx' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'Array',
                    'description' => '<p>
	Key as field name, value as field type SQL style (ex: <code>VARCHAR( 500 ) NOT NULL</code>)</p>
',
                  ),
                ),
                'name' => 'init_table($name,$fields)',
                'description' => '<p>
	Create a database table with the given fields</p>
',
                'return' => 'True on success, False on failure',
              ),
              'insert' => 
              array (
                'name' => 'insert($table_name, $fields=array(), $return_index=false)',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'param:table_name' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table_name',
                    'type' => 'String',
                    'description' => 'The table to insert into',
                  ),
                  'param:fields' => 
                  array (
                    'name' => '$fields',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'type' => 'Array',
                    'description' => 'Key=>Value pairs corresponding to Column Name and Value',
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                  ),
                  'param:return_index' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$return_index',
                    'type' => 'Boolean',
                    'description' => '<p>
	Return the index of the new record instead of True on success (Default: false)</p>
',
                  ),
                  'lhsemhhrfp' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Insert an item into a table',
                    'code' => '$node->db_mysql->insert(\'myTable\',array(\'field1\'=>\'myval\', \'field2\'=>\'another value\'));',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'return' => 'False on failure, True on success or integer containing the new record\'s ID if the $return_index parameter is True.',
              ),
              'select' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'esnqiwehno' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table_name',
                    'type' => 'String',
                    'description' => '<p>
	Table to select from</p>
',
                  ),
                  'ktvcdpbmha' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'String',
                    'description' => '<p>
	Array of columns to get, or string to pass directly to query</p>
',
                  ),
                  'hjogxisyah' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$limit',
                    'type' => 'String/Array',
                    'description' => '<p>
	String for extra to place after where clause (e.g. could also contain &#39;ORDER BY&#39;) or 2 item array matching array($startPosition,$limitLength)</p>
',
                  ),
                ),
                'name' => 'select($table_name,$fields=\'*\',$where=array(),$limit=\'\')',
                'description' => '<p>
	Select data from a table</p>
',
                'return' => 'Array on success, False on failure',
              ),
              'update' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'lnkqcypryk' => 
                  array (
                    'type' => 'String',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => '<p>
	Table to update rows in</p>
',
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'name' => '$table_name',
                  ),
                  'brubsthywd' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$where',
                    'type' => 'Array',
                    'description' => '<p>
	Column=&gt;Value to match for updating</p>
',
                  ),
                  'nxmwisrxji' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'Array',
                    'description' => '<p>
	Column=&gt;Value to set on update</p>
',
                  ),
                  'dclwbfggss' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$versioning',
                    'type' => 'Boolean',
                    'description' => '<p>
	Instead of overwriting data, create new version (default: false)</p>
<p>
	Updating with version control requires the record&#39;s id to be specified</p>
',
                  ),
                ),
                'name' => 'update($table_name,$where,$fields,$versioning=false)',
                'description' => '<p>
	Update records in a table</p>
',
                'return' => 'True on success, False on failure',
              ),
            ),
            'description' => 'Abstraction of basic MySQL functions for use in modules. This is the description.',
            'pattern:match' => '/patterns/documentation/module-list/module',
          ),
          'img_resize' => 
          array (
            'name' => 'img_resize',
            'node:owner' => '1',
            'node:children' => 
            array (
              'load' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'zmytbgfbwd' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$file',
                    'type' => 'String',
                    'description' => '<p>
	Filename of image to resize</p>
',
                  ),
                  'lbioprzjoi' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$width',
                    'type' => 'Integer',
                    'description' => '<p>
	In pixels, new image width</p>
',
                  ),
                  'zisaowrsdu' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$height',
                    'type' => 'Integer',
                    'description' => '<p>
	In pixels, new image height</p>
',
                  ),
                  'pvsotwndqq' => 
                  array (
                    'type' => 'Boolean',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => '<p>
	False to fit the image to the dimensions or true to crop the image to fill the dimensions given (default: false)</p>
',
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'name' => '$center',
                  ),
                ),
                'name' => 'load($file,$width,$height,$center=false)',
                'description' => '<p>
	Create a thumbnail for the specified cached image and return the new filename</p>
',
                'return' => 'String filename',
              ),
            ),
            'description' => 'Use installed ImageMagick to resize/crop images for display',
            'pattern:match' => '/patterns/documentation/module-list/module',
          ),
          'record_attribute' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
              'attach' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'aesaxbwsaw' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table containing items with attributes</p>
',
                  ),
                  'ehcmqgzcvv' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$input_array',
                    'type' => 'Array',
                    'description' => '<p>
	Keys of array items are item IDs. Overlapping attributes with existing item attribute keys are suffixed with &#39;_attr&#39;.</p>
',
                  ),
                  'mrxutmxdgw' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Load attributes on all users',
                    'code' => 'print_r($node->record_attribute->attach($node->user_user->table, $node->db->select($node->user_user->table, array(\'name\'))));
',
                  ),
                ),
                'name' => 'attach($table,$input_array)',
                'description' => '<p>
	Load attributes for an array with keys of ids in a specified table, typically a selection of rows.</p>
',
                'return' => 'Array',
              ),
              'delete' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'htooaolnhe' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table containing items to remove attributes from</p>
',
                  ),
                  'nhqvwneusn' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$id',
                    'type' => 'Integer/Array',
                    'description' => '<p>
	Item ID or array of item IDs to remove attributes from</p>
',
                  ),
                  'nggqszktbk' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$key',
                    'type' => 'String/Array',
                    'description' => '<ul>
	<li>
		Omit remove all attribute keys</li>
	<li>
		Pass a string or array of strings to specify which attributes to remove</li>
</ul>
',
                  ),
                ),
                'name' => 'delete($table,$id,$key=\'\')',
                'description' => '<p>
	Delete attributes from an item or aray of items</p>
',
                'return' => 'True on success, False on failure',
              ),
              'get' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'csyvgktxgt' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table containing items</p>
',
                  ),
                  'xsxrpfjujf' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$id',
                    'type' => 'Integer',
                    'description' => '<p>
	Item ID to retrieve attributes for</p>
',
                  ),
                  'ljjygjtyhx' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$key',
                    'type' => 'String/Array',
                    'description' => '<ul>
	<li>
		Omit to select all attributes</li>
	<li>
		Pass string or array to select which attributes</li>
</ul>
',
                  ),
                ),
                'name' => 'get($table,$id,$key=\'\')',
                'description' => '<p>
	Retrieve attribute(s) for an item</p>
',
                'return' => 'Array on success, False on failure',
              ),
              'post' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'ndsbpiqqiv' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'Array',
                    'description' => '<p>
	Available actions:</p>
<ul>
	<li>
		<strong>Set</strong> - table, id, attr[key][], attr[value][], versioning (optional)
		<ul>
			<li>
				Also accepts file uploads with name &#39;file_[key]&#39;</li>
		</ul>
	</li>
	<li>
		<strong>Delete</strong> -table, id, attr</li>
</ul>
',
                  ),
                  'jtopuzqrle' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Update the \'requirements\' and \'description\' attributes on item 34629 in the \'tree_items\' table. Notice how attribute keys and values are separate fields that must remain in order.',
                    'code' => '&lt;input name="fields[attr][key][]" type="hidden" value="requirements"&gt;
&lt;textarea name="fields[attr][value][]"&gt;&lt;/textarea&gt;
&lt;input name="fields[attr][key][]" type="hidden" value="description"&gt;
&lt;textarea name="fields[attr][value][]"&gt;&lt;/textarea&gt;
&lt;input name="fields[id]" type="hidden" value="34629"&gt;
&lt;input name="fields[table]" type="hidden" value="tree_items"&gt;
&lt;input name="action" type="hidden" value="record_attribute/set"&gt;',
                  ),
                ),
                'name' => 'post($fields)',
                'description' => '<p>
	Post handler for item attribute operations</p>
',
                'return' => 'String status message',
              ),
              'set' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'irbfrpoqof' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table containing items</p>
',
                  ),
                  'uoytmgulry' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$id',
                    'type' => 'Integer',
                    'description' => '<p>
	Item ID to set attributes on</p>
',
                  ),
                  'hjbepqskbv' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$attributes',
                    'type' => 'Array',
                    'description' => '<p>
	Key=&gt;Value pairs to attach to item</p>
',
                  ),
                  'ykdhhpccnm' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$versioning',
                    'type' => 'Boolean',
                    'description' => '<p>
	Enable version control instead of overwriting current value (default: false)</p>
',
                  ),
                ),
                'name' => 'set($table,$id,$attributes,$versioning=false)',
                'description' => '<p>
	Set attribute(s) on items</p>
',
                'return' => 'True on success, False on failure',
              ),
            ),
            'name' => 'record_attribute',
            'description' => 'Apply key=>value attributes to other tables\' items. Originally separate from the data tree but integrated in record_tree2.',
          ),
          'record_group' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
              'associate' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'faqbivpvvn' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to associate items</p>
',
                  ),
                  'rmbkmqfhyw' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$groups',
                    'type' => 'Array',
                    'description' => '<p>
	Items can be string group names or integer group IDs</p>
',
                  ),
                  'bsobjrfxzr' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$items',
                    'type' => 'Array',
                    'description' => '<p>
	Item IDs to associate to group(s)</p>
',
                  ),
                ),
                'name' => 'associate($table,$groups,$items)',
                'description' => '<p>
	Associate item(s) with group(s)</p>
',
                'return' => 'True on success, False on failure',
              ),
              'create' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'rywskjgohy' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to create groups for</p>
',
                  ),
                  'gygfociyqu' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$names',
                    'type' => 'Array',
                    'description' => '<p>
	Group names to be created</p>
',
                  ),
                ),
                'name' => 'create($table,$names=array())',
                'description' => '<p>
	Create groups in a table based on an array of group names</p>
',
                'return' => 'True on success, False on Failure',
              ),
              'delete' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'opabzygaqn' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to delete group(s) from</p>
',
                  ),
                  'mzcmtyoeiv' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$group',
                    'type' => 'String/Integer/Array',
                    'description' => '<ul>
	<li>
		Omit to delete all groups from a table.</li>
	<li>
		Pass integer to delete a group based on ID.</li>
	<li>
		Pass string to delete group based on name.</li>
	<li>
		Pass array to delete multiple groups by ID or name.</li>
</ul>
',
                  ),
                ),
                'name' => 'delete($table,$group=\'\')',
                'description' => '<p>
	Delete a group or range of groups</p>
',
                'return' => 'True on success, False on failure',
              ),
              'disassociate' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'upogeozxdp' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to disassociate items from</p>
',
                  ),
                  'vmilgrtrgx' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$group',
                    'type' => 'String/Integer/Array',
                    'description' => '<ul>
	<li>
		Omit or pass empty string for all groups</li>
	<li>
		Pass string for group name, integer for group ID</li>
	<li>
		Pass array with combination of group name string / group ID integer</li>
</ul>
',
                  ),
                  'vvghbcmmgz' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$items',
                    'type' => 'Integer/Array',
                    'description' => '<ul>
	<li>
		Omit or pass empty string to disassociate all items</li>
	<li>
		Pass integer or array of integers of item IDs</li>
</ul>
',
                  ),
                ),
                'name' => 'disassociate($table,$group=\'\',$items=\'\')',
                'description' => '<p>
	Disassociate item(s) from group(s)</p>
',
                'return' => 'True on success, False on failure',
              ),
              'list_groups' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'flagcvxfoc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to list groups for</p>
',
                  ),
                  'aznhmepbhk' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$group',
                    'type' => 'String/Integer/Array',
                    'description' => '<ul>
	<li>
		Omit to list all groups for this table</li>
	<li>
		Pass string or integer to limit to one group name or ID</li>
	<li>
		Pass array to limit to a selection of group names or IDs</li>
</ul>
',
                  ),
                ),
                'name' => 'list_groups($table,$group=\'\')',
                'description' => '<p>
	List the groups available for a table or specific which groups to check for existence</p>
',
                'return' => 'Array on success, False on failure',
              ),
              'list_members' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'ephhxzvpcc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to load group members from</p>
',
                  ),
                  'wtpnyfmbft' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$group',
                    'type' => 'String/Integer/Array',
                    'description' => '<ul>
	<li>
		Omit or pass empty string to not filter by group.</li>
	<li>
		Pass string for group name, integer for group ID or array of combination.</li>
</ul>
',
                  ),
                  'hwxonldmka' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$item_id',
                    'type' => 'Integer/Array',
                    'description' => '<ul>
	<li>
		Omit to allow any items from table</li>
	<li>
		Pass integer or array of integers to specify which items to include</li>
</ul>
',
                  ),
                ),
                'name' => 'list_members($table,$group=\'\',$item_id=\'\')',
                'description' => '<p>
	List the members of groups in a table, optionally filtering by group, item ID or both.</p>
',
                'return' => 'Array on success, False on failure',
              ),
              'load_list' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'aficsbwbbr' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$list',
                    'type' => 'Array',
                    'description' => '<p>
	Usually the return value from $this-&gt;list_members(), an array of arrays that contain two key=&gt;value pairs for the keys &#39;group&#39; and &#39;item_id&#39;.</p>
',
                  ),
                  'ysgjnsjftu' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'String/Array',
                    'description' => '<p>
	Pass a string to the MySQL query for which fields to load or pass an array of field names. (Default &#39;*&#39;, all fields)</p>
',
                  ),
                  'gztkklsyhe' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Display all the user associations with their groups',
                    'code' => 'print_r($node->record_group->load_list($node->record_group->list_members(\'users\')));',
                  ),
                  'qcduwghamy' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Load out user associations for the \'Administrators\' group.',
                    'code' => 'print_r($node->record_group->load_list($node->record_group->list_members(\'users\',\'Administrators\')));',
                  ),
                ),
                'name' => 'load_list($list,$fields=\'*\')',
                'description' => '<p>
	Populate a loaded list of group members with fields from their table and organize them based on group ID</p>
',
                'return' => 'Array on success, False on failure',
              ),
              'post' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'vvbipdqsnr' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'Array',
                    'description' => '<p>
	Available Actions and the field names for the corresponding functions:</p>
<ul>
	<li>
		<strong>Create</strong> - table, name</li>
	<li>
		<strong>Rename</strong> -&nbsp;table, group, name</li>
	<li>
		<strong>Delete</strong> -&nbsp;table, group</li>
	<li>
		<strong>Associate</strong> -&nbsp;table, group, id</li>
	<li>
		<strong>Disassociate</strong> -&nbsp;table, group, id</li>
</ul>
',
                  ),
                  'owsbztiing' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Simplified form data for disassociating a user from a group',
                    'code' => '&lt;input name="action" value="record_group/disassociate" /&gt;
&lt;input name="fields[table] value="users" /&gt;
&lt;input name="fields[group][] value="4" /&gt;
&lt;input name="fields[id][] value="1" /&gt;',
                  ),
                  'ynivuqauhy' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Simplified form data for deleting a group',
                    'code' => '&lt;input name="action" value="record_group/delete" /&gt;
&lt;input name="fields[table]" value="users" /&gt;
&lt;input name="fields[group]" value="4" /&gt;
',
                  ),
                ),
                'name' => 'post($fields)',
                'description' => '<p>
	Post handler for group operations</p>
',
                'return' => 'String status message',
              ),
              'rename' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'wngguwlahs' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Table to rename group from</p>
',
                  ),
                  'bqcycxgqlx' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$group',
                    'type' => 'String/Integer',
                    'description' => '<p>
	Name or ID of group to rename</p>
',
                  ),
                  'xpxgqezfuc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$new_name',
                    'type' => 'String',
                    'description' => '<p>
	New name of group</p>
',
                  ),
                ),
                'name' => 'rename($table,$group,$new_name)',
                'description' => '<p>
	Rename a group</p>
',
                'return' => 'True on success, False on failure',
              ),
              'translate_to_id' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'pjcvxrikok' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$table',
                    'type' => 'String',
                    'description' => '<p>
	Name of the table that these groups belong to.</p>
',
                  ),
                  'eowwmyqmgs' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$group',
                    'type' => 'String/Array',
                    'description' => '<p>
	Pass group name as string for single tranlation. Pass array of group names for multiple translations. Integers are passed through without translation.</p>
',
                  ),
                ),
                'name' => 'translate_to_id($table,$group)',
                'description' => '<p>
	Convert a group name or array of names into group ID numbers</p>
',
                'return' => 'Integer if string passed for $group, Array if array',
              ),
            ),
            'name' => 'record_group',
            'description' => 'Class to manage groups of items in other tables',
          ),
          'record_tree2' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
              'access_id_load' => 
              array (
                'description' => '<p>
	Retrieve the label of an access group, either the user&#39;s name if greater than 0, the group name if less than -100 or the special group name otherwise.</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'twngcacijv' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$accessId',
                    'type' => 'Integer',
                    'description' => '<p>
	Integer corresponding to a user or group of users to retrieve display information.</p>
<ul>
	<li>
		-100 to 0 reserved for special items&nbsp;<span style="color: rgb(51, 51, 51); font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 18px; ">(0: world, -1: all logged in users)</span></li>
	<li>
		Greater than 0 is user ids</li>
	<li>
		Less than -100 is for group ids (group id-100 for value)</li>
</ul>
',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'access_id_load($accessId)',
                'return' => 'Array containing display information of a permission rule accessor',
              ),
              'bind' => 
              array (
                'description' => '<p>
	Bind an event to an action on a query of tree items</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'ruapmrbhqq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address to bind event</p>
',
                  ),
                  'vouabxzmrb' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$modeString',
                    'type' => 'String',
                    'description' => '<p>
	Contains letters corresponding to which roles this function will be called for.</p>
<p>
	Read <code>r</code>, Edit/Rename <code>w</code>, Insert <code>i</code>, Move <code>m</code>, Sort <code>s</code>, Move <code>m</code>, Set Owner <code>o</code>, and Set Permissions <code>p</code></p>
<p>
	Example: Read, Write and Insert &#39;rwi&#39;</p>
',
                  ),
                  'ohsoolmqoc' => 
                  array (
                    'description' => '<p>
	Accepted values: &#39;validate&#39;, &#39;complete&#39;</p>
',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'name' => '$type',
                    'type' => 'String',
                  ),
                  'tmdklrooat' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$function',
                    'type' => 'Anonymous function to call',
                    'description' => '<p>
	New with php 5.3, put functions anywhere like in JavaScript!</p>
<p>
	Unless specified otherwise below only, return False to cancel an event from proceeding, True to continue.&nbsp;</p>
<p>
	<strong><span style="font-size:14px;">Validation event function parameters</span></strong></p>
<p>
	<strong>Insert &#39;i&#39;:</strong> <code>function($address,&nbsp;$node, $curItem, $data)</code></p>
<ul>
	<li>
		If an array is returned, the data is replaced.</li>
</ul>
<p>
	&nbsp;</p>
<p>
	<strong>Write Item (Edit, Insert) &#39;w&#39;:</strong> <code>function($address,&nbsp;$node, $curItem, $data)</code></p>
<ul>
	<li>
		$curItem will be a blank array on item insert.</li>
	<li>
		If an array is returned, the data is replaced.</li>
</ul>
<p>
	&nbsp;</p>
<p>
	<strong>Set Owner &#39;o&#39;:</strong> <code>function($address,&nbsp;$node, $curItem, $userId)</code></p>
<p>
	&nbsp;</p>
<p>
	<strong>Delete &#39;d&#39;:</strong> <code>function($address,&nbsp;$node, $curItem, $specAddress, $attribute)</code></p>
<ul>
	<li>
		$specAddress included as the specified address to delete for comparing whether or not the operation is deleting the item or its range.</li>
	<li>
		$attribute is False for deleting the entire item, or the string of the attribute to remove</li>
</ul>
<p>
	&nbsp;</p>
<p>
	<strong>Move, Rename &#39;m&#39;:</strong> <code>function($address,&nbsp;$node, $curItem, $newItemAddress)</code></p>
<p>
	&nbsp;</p>
<p>
	<strong>Sort &#39;s&#39;:</strong> <code>function($address,&nbsp;$node, $parent, $ordered)</code></p>
<ul>
	<li>
		$parent is loaded parent item, $ordered is array of child addresses in order</li>
</ul>
<p>
	&nbsp;</p>
<p>
	<strong>Read&nbsp;&#39;r&#39;:</strong> <code>function($address,&nbsp;$node, $depth, $isRange)</code></p>
<ul>
	<li>
		Return an array to replace output data</li>
	<li>
		The $address parameter will always be an item address (except for the root). The $isRange boolean parameter denotes whether this read is for the item or for its range of children.</li>
</ul>
<p>
	&nbsp;</p>
<p>
	<strong>Set Permission &#39;p&#39;:</strong> <code>function($address, $node, $mode, $accessors)</code></p>
<p>
	&nbsp;</p>
<p>
	<strong><span style="font-size:14px;">Completion event function parameters</span></strong></p>
<p>
	All operation types except specified otherwise follow this parameter scheme (return value ignored):</p>
<p>
	<code>function($address, $node)</code></p>
<p>
	<strong>Read &#39;r&#39;:&nbsp;</strong><code>function($address, $node, $data)</code></p>
<ul>
	<li>
		An array can be returned to replace the data or false can be returned to cancel the operation</li>
</ul>
<p>
	<strong>Insert &#39;i&#39;:&nbsp;</strong><code>function($address, $node, $curItem, $data)</code></p>
<p>
	&nbsp;</p>
<p>
	<strong>Write &#39;w&#39;:&nbsp;</strong><code>function($address, $node, $curItem, $data)</code></p>
<p>
	&nbsp;</p>
<p>
	<strong>Move &#39;m&#39;:&nbsp;</strong><code>function($address, $node, $oldAddress)</code></p>
<p>
	&nbsp;</p>
<p>
	<strong>Delete &#39;d&#39;:</strong>&nbsp;<code>function($address, $node, $attribute)</code></p>
<ul>
	<li>
		The $attribute parameter will contain false for deleting the entire item or a string containing the attribute name.</li>
</ul>
',
                  ),
                  'vogzejaevx' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Make items with attribute &#39;admin:locked&#39; set to true unable to be written, sorted, inserted or moved in your home directory',
                    'code' => '$this->tree->bind(&#34;~/node:wild-recursive-or-nothing/node:attributes(`admin:locked`=&#39;true&#39;)&#34;, &#39;wsim&#39;, &#39;validate&#39;, 
function($address,$node,$curItem,$data){
	return false;
});',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'bind($address,$modeString,$type,$function)',
                'return' => 'Undefined',
              ),
              'chmod' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'hvemuamomt' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address of item or data root to set permission rule on (default: &#39;/&#39;)</p>
',
                  ),
                  'uudbqlqgyt' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$mode',
                    'type' => 'Integer',
                    'description' => '<p>
	Value of the mode for this permission setting in decimal format using sum of desired roles (Read: 1, Write: 2, Insert: 4, Delete: 8, Sort: 16, Move: 32, Set Owner: 64, Set Permissions: 128)</p>
',
                  ),
                  'syjafbqdip' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$accessors',
                    'type' => 'Array',
                    'description' => '<p>
	Each item in the array is an integer corresponding to a user or group of users to set.</p>
<ul>
	<li>
		-100 to 0 reserved for special items (0: world, -1: all logged in users)</li>
	<li>
		Greater than 0 is user ids</li>
	<li>
		Less than -100 is for group ids (group id-100 for value)</li>
</ul>
',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'name' => 'chmod($address="/",$mode=0,$accessors=array(),$suppressEvents=false)',
                'return' => 'True on success, False on failure',
                'description' => '<p>
	Change the mode of an item for a specific access group</p>
',
              ),
              'chown' => 
              array (
                'description' => '<p>
	Change of the owner of an item</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'wfedzrumvi' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => 'Item address to change owner of',
                  ),
                  'ugdofcfobc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$userId',
                    'type' => 'Integer',
                    'description' => 'ID of item from module User_user',
                  ),
                  'cteptstiom' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$propagate',
                    'type' => 'Boolean',
                    'description' => 'Perform this operation on the children (required for any action if address is a range, default: true)',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'chown($address,$userId,$propagate=true,$suppressEvents=false)',
                'return' => 'True on success, False on failure',
              ),
              'copy' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'crtsersxfi' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => 'Address of item or range to copy',
                  ),
                  'sdpxnnknei' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$newAddress',
                    'type' => 'String',
                    'description' => 'Address range to move item to',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'name' => 'copy($itemAddress,$newAddress,$suppressEvents=false)',
                'return' => 'True on success, False on failure',
                'description' => '<p>
	Copy one item into another. If copying one item to the same parent, it will be renamed with a random value. If copying to different parent, it will fail if the item name already exists.</p>
',
              ),
              'delete' => 
              array (
                'description' => '<p>
	Delete an item or a single attribute from an item</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'sjzuhpimcj' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => 'Address of item to delete',
                  ),
                  'jycwemxngi' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$attribute',
                    'type' => 'String',
                    'description' => 'Key of attribute to delete if not whole item (default: false)',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'delete($address,$attribute=false,$suppressEvents=false)',
                'return' => 'True on success, False on failure',
              ),
              'edit' => 
              array (
                'description' => '<p>
	Edit an already existing item</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'tosuyirhvo' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => 'Item address to write to',
                  ),
                  'amabbglmui' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$data',
                    'type' => 'Array',
                    'description' => 'Key=>Value pairs to set on this item',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                  'rnilyarokl' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '0',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Some code',
                    'code' => 'You\'ve just been farked around!',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'edit($address,$data,$suppressEvents=false)',
                'return' => 'True on success, False on failure',
              ),
              'filter_address' => 
              array (
                'description' => '<p>
	Perform any loaded address modifiers on an address</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'apeemmwdkk' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address to get run through configured filters</p>
',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'filter_address($address)',
                'return' => 'String containing modified address',
              ),
              'event' => 
              array (
                'description' => '<p>
	Call an event on an item</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'eccrsyaapt' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address of item to call event</p>
',
                  ),
                  'eyvmjzknre' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$role',
                    'type' => 'String',
                    'description' => '<p>
	One character denoting which type of event (r, w, i, s, d, m, o, p)</p>
',
                  ),
                  'ohsoolmqoc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$type',
                    'type' => 'String',
                    'description' => '<p>
	Accepted values: &#39;validate&#39;, &#39;complete&#39;</p>
',
                  ),
                  'lbgmyrqezc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$extraArgs',
                    'type' => 'Array',
                    'description' => '<p>
	Any extra parameters to add to the event function call after $address and $node</p>
',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'event($address,$role,$type,$extraArgs=array())',
                'return' => 'True on success, False on failure',
              ),
              'get' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'teqbsbbgeh' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address of item or range to grab (default: &#39;/&#39;)</p>
',
                  ),
                  'iodtrwqgot' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$depth',
                    'type' => 'Boolean/Integer',
                    'description' => '<ul>
	<li>
		<strong>False</strong> (default) - Return only initial level</li>
	<li>
		<strong>True</strong> - Return all levels of children</li>
	<li>
		<em>Integer</em> - Return a specific number of levels deep (0 for immediate children, 1 for the next level of children, etc.)</li>
</ul>
',
                  ),
                  'jqpaqmsmvk' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressPermissions',
                    'type' => 'Boolean',
                    'description' => 'Suppress the validation of read permissions (default:false)',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'name' => 'get($address=\'/\',$depth=false,$suppressPermissions=false,$suppressEvents=false)',
                'return' => 'Array on success, False on failure',
                'description' => '<p>
	Retrieve data from the tree</p>
',
              ),
              'get_wild' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'xusjouxvld' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address string to grab including wildcards (&#39;node:wild&#39;, &#39;node:wild-or-nothing&#39;, &#39;node:wild-recursive&#39;, &#39;node:wild-recursive-or-nothing&#39;), &#39;node:starts-with([term])&#39;, node:ends-with([term])&#39;, and &#39;node:attributes([attribute string])&#39;. Attribute strings can contain parentheses with boolean (&#39;and&#39;, &#39;or&#39;, &#39;not&#39;) and key comparison with operators (&#39;=&#39;, &#39;!=&#39;, &#39;&gt;&#39;, &#39;&lt;&#39;, &#39;&gt;=&#39;, &#39;&lt;=&#39;).</p>
<p>
	Valid attributes to look in also include those prefixed with &#39;node:&#39;.</p>
',
                  ),
                  'eeurcxtavr' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$onlyAddresses',
                    'type' => 'Boolean',
                    'description' => 'Return only an array of possible addresses instead of items loaded fully (default: false)',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                  'heuxnvihjn' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Print all home item addresses with attribute \'admin:edit-count\' greater than 10.',
                    'code' => 'print_r(array_keys($node->record_tree2->get_wild("/home/node:attributes(`admin:edit-count` > \'10\')")));',
                  ),
                  'mflqfqimmz' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Print item addresses of items in current user\'s home item with a name that starts with \'horse\'',
                    'code' => 'print_r(array_keys($node->record_tree2->get_wild("~/node:starts-with(horse)")));',
                  ),
                ),
                'name' => 'get_wild($address,$onlyAddresses=false,$suppressEvents=false)',
                'return' => 'Array on success, False on failure',
                'description' => '<p>
	Retrieve data from the tree with a complex data query address</p>
',
              ),
              'has_role' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'nvusdpdpuw' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => 'Arguments',
                    'type' => 'Array',
                    'description' => '<p>
	Grabs arguments as array: first for which role to check, proceeding are combined to make up the item address or data root. Use in config.ini files for checking posts.</p>
<div>
	&nbsp;</div>
<div>
	Examples:</div>
<div>
	check_root_owner[] = &quot;record_tree2/has_role/o/&quot;</div>
<div>
	check_can_write[] = &quot;record_tree2/has_role/w/rootItemName/childItemName&quot;</div>
',
                  ),
                ),
                'name' => 'has_role()',
                'return' => 'Boolean',
                'description' => '<p>
	On form posts, check if the current user has a role available on an item</p>
',
              ),
              'insert' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'baaaoiwwbe' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address range to insert into (default: &#39;/&#39;)</p>
',
                  ),
                  'lfsrhauufs' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$data',
                    'type' => 'Array',
                    'description' => 'Items to be inserted',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                  'kcobmuhzsk' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Insert Multiple Items into the Root. Notice the item with the partial randomization in the name.',
                    'code' => '$node->record_tree2->insert(&#39;/&#39;, 
	array(
		&#39;myitem&#39;=>array(
			&#39;foo&#39;=>&#39;bar&#39;,
			&#39;admin:icon&#39;=>&#39;plane&#39;
			),
		&#39;nextitem&#39;=>array(
			&#39;some&#39;=>&#39;val&#39;,
			&#39;node:children&#39;=>array(
				&#39;childItem&#39;=>array(
					&#39;another&#39;=>&#39;value&#39;
					),
				&#39;anotherChild-#RAND#&#39;=>array(
					&#39;some&#39;=>&#39;value&#39;
					)
				)
			)
		));
',
                  ),
                ),
                'name' => 'insert($address=\'/\', $data=array(), $suppressEvents=false)',
                'return' => 'True on success, False on failure',
                'description' => '<p>
	Insert item(s) into the tree</p>
',
              ),
              'mode' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'icjvedsoxh' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$address',
                    'type' => 'String',
                    'description' => '<p>
	Address of item or data root to retrieve mode</p>
',
                  ),
                  'zfzojvmylq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$userId',
                    'type' => 'Integer',
                    'description' => '<p>
	ID of item from module User_user (default: false =&gt; current user)</p>
',
                  ),
                  'ylhfrgnkoa' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$knowExists',
                    'type' => 'Boolean',
                    'description' => '<p>
	Bypass checking to see if the item actually exists and just look for permission values (default: false)</p>
',
                  ),
                ),
                'name' => 'mode($address="/",$userId=false,$knowExists=false)',
                'return' => 'Integer on success, False on failure',
                'description' => '<p>
	Retrieve the mode an item</p>
',
              ),
              'mode_to_roles' => 
              array (
                'description' => '<p>
	Convert an integer mode value into an array of booleans for each role</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'cwxsuejoaz' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$mode',
                    'type' => 'Integer',
                    'description' => '<p>
	For translating to easily computed boolean array</p>
',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'mode_to_roles($mode)',
                'return' => 'Array of \'Role Character\'=>\'True/False\'',
              ),
              'move' => 
              array (
                'name' => 'move($itemAddress,$newAddress,$suppressEvents=false)',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'crtsersxfi' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$itemAddress',
                    'type' => 'String',
                    'description' => 'Address of item to move',
                  ),
                  'sdpxnnknei' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$newAddress',
                    'type' => 'String',
                    'description' => 'Address range to move item to',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'return' => 'True on success, False on failure',
                'description' => '<p>
	Move an item to another parent</p>
',
                'pattern:match' => '/patterns/documentation/module-list/module/function',
              ),
              'post' => 
              array (
                'description' => '<p>
	Post handler for tree operations</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'xzbpiinxcs' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$fields',
                    'type' => 'Array',
                    'description' => '<p>
	Available actions:</p>
<ul>
	<li>
		<strong>rename</strong> -&nbsp;address, name</li>
	<li>
		<strong>delete</strong> -&nbsp;address, key (optional)</li>
	<li>
		<strong>insert</strong> -&nbsp;address, data[][...]</li>
	<li>
		<strong>edit</strong> - address, data[]</li>
	<li>
		<strong>sort</strong> -&nbsp;address, ordered[]</li>
	<li>
		<strong>move</strong> -&nbsp;address, newAddress</li>
	<li>
		<strong>copy</strong> -&nbsp;address, newAddress</li>
	<li>
		<strong>chmod</strong> -&nbsp;address, mode, accessors[]</li>
	<li>
		<strong>chown</strong> -&nbsp;address, user</li>
	<li>
		<strong>get</strong> -&nbsp;address, depth (returns array instead of string)</li>
	<li>
		<strong>get_mode</strong> -&nbsp;address (returns array instead of string)</li>
</ul>
',
                  ),
                ),
                'return' => 'String status message',
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'post($fields)',
              ),
              'query' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'vabevwfoug' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$rootAddress',
                    'type' => 'String',
                    'description' => '<p>
	Address range to begin searching from (default: &#39;/&#39;)</p>
',
                  ),
                  'pagbuhjioi' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$args',
                    'type' => 'Array/String',
                    'description' => '<p>
	Example query argument array: array(&#39;somekey&#39; =&gt; array(&#39;value&#39; =&gt; &#39;33&#39;, &#39;operator&#39; =&gt; &#39;&gt;&#39;), &#39;otherkey&#39; =&gt; &#39;someval&#39;, &#39;query:mode&#39; =&gt; &#39;[and|or|not]&#39;)</p>
<p>
	Arguments can contain nested arrays without the key set to perform complex boolean operations.</p>
<p>
	Key values containing &#39;%&#39; (percent symbol) will be matched using the like operator.</p>
<p>
	Example: String values can also be used: $args=&quot;(`name`=&#39;itemName&#39; and `foobar`&gt;&#39;32&#39;) or (`name`=&#39;somethingElse&#39; and `foobar`&lt;=&#39;7&#39;)&quot;</p>
<p>
	Always use single quotes inside argument string values.</p>
',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                  'yruolaforg' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$onlySearch',
                    'type' => 'Boolean',
                    'description' => '<p>
	Internal variable for recursive operations (no need to ever specify)</p>
',
                  ),
                  'jxxryseeua' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Load all nodes which contain \'horse\' somewhere in any field.',
                    'code' => 'print_r($node->record_tree2->query(\'/\',"`%` like \'%horse%\'"));',
                  ),
                  'ddugmrpdwa' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Print all home item attributes with attribute \'admin:edit-count\' greater than 10.',
                    'code' => 'print_r(array_keys($node->record_tree2->query(\'~/..\', "`admin:edit-count` > \'10\'", 1)));',
                  ),
                  'srtifozhco' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Load all the comments that match the documentation\'s comment pattern.',
                    'code' => '$comments=$node->record_tree2->query(\'/\',"`pattern:match`=\'/patterns/documentation/module-list/module/function/comment\'");',
                  ),
                ),
                'name' => 'query($rootAddress=\'/\',$args=array(),$depth=true,$suppressEvents=false,$onlySearch=false)',
                'return' => 'Array on success, False on failure',
                'description' => '<p>
	Perform a query for a specific pattern of attributes</p>
',
              ),
              'rename' => 
              array (
                'description' => '<p>
	Rename an item</p>
',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'vhthebwflr' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$itemAddress',
                    'type' => 'String',
                    'description' => 'Address of item to rename',
                  ),
                  'svtlpsswxk' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$newName',
                    'type' => 'String',
                    'description' => 'New value for the name of item',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'name' => 'rename($itemAddress,$newName,$suppressEvents=false)',
                'return' => 'True on success, False on failure',
              ),
              'sort' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'hmgybzxaqb' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$parentAddress',
                    'type' => 'String',
                    'description' => 'Address of parent item in order to check permissions',
                  ),
                  'ajtqzizzjg' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$ordered',
                    'type' => 'Array',
                    'description' => 'Array values of addresses of items to be placed into order',
                  ),
                  'vviqzvnnpq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$suppressEvents',
                    'type' => 'Boolean',
                    'description' => 'Suppress the execution of event code while performing this action (default: false)',
                  ),
                ),
                'name' => 'sort($parentAddress,$ordered,$suppressEvents=false)',
                'return' => 'True on success, False on failure',
                'description' => '<p>
	Update the sort order of an array of items</p>
',
              ),
            ),
            'name' => 'record_tree2',
            'description' => 'Data tree class with integrated user access controls',
          ),
          'render_haml' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
              'render' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'mjpimtqdsb' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$page',
                    'type' => 'String',
                    'description' => '<p>
	Template address excluding main template directory and file extension.</p>
<p>
	E.g. For <code>./tpl/blocks/test.haml</code> use <code>blocks/test</code></p>
',
                  ),
                  'tpgqnnbprt' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$render_params',
                    'type' => 'Array',
                    'description' => '<p>
	Data to pass to the page being rendered</p>
',
                  ),
                  'lnluvfazru' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$template',
                    'type' => 'String/False',
                    'description' => '<ul>
	<li>
		Omit or pass empty string to use default template</li>
	<li>
		Pass string to specific template or False to force no template</li>
</ul>
',
                  ),
                  'ufqvraaepe' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$return',
                    'type' => 'Boolean',
                    'description' => '<p>
	Return the HTML instead of printing directly to the output (default: false)</p>
',
                  ),
                ),
                'name' => 'render($page=\'\',$render_params=array(),$template=\'\',$return=false)',
                'description' => '<p>
	Render a page</p>
',
                'return' => 'Undefined unless $return parameter is True, then HTML as string',
              ),
            ),
            'name' => 'render_haml',
            'description' => 'Parse HAML templates and render them with associated templates',
          ),
          'tree_home' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'name' => 'tree_home',
            'description' => 'Create a space in the data tree for each user to store personal data',
          ),
          'tree_pattern' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
              'validate' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'qgumvjujfh' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$data',
                    'type' => 'Array',
                    'description' => '<p>
	Attributes to use with patterned items:</p>
<ul>
	<li>
		<strong>pattern:children</strong> - Address of the item containing the pattern for the children of this item, use on the container for patterned items</li>
	<li>
		<strong>pattern:match</strong> - Address of the item containing the pattern for the current item, required for all items conforming to patterns</li>
</ul>
<p>
	On the pattern items, other attributes can be used to perform validation with the class:</p>
<ul>
	<li>
		<strong>specificity</strong> - Set to &#39;<em>vague</em>&#39; for items of this type to not have to conform to the given fields</li>
	<li>
		<strong>max-length</strong> - Maximum string length for field</li>
	<li>
		<strong>min-length</strong> - Minimum string length for field</li>
	<li>
		<strong>max-value</strong> - Maximum value for field</li>
	<li>
		<strong>min-value</strong> - Minimum value for field</li>
	<li>
		<strong>type</strong> - &#39;<em>array</em>&#39;, &#39;<em>recursive</em>&#39; to allow child definitions, otherwise field assumed</li>
	<li>
		<strong>data-type</strong> - Set data type for validation:
		<ul>
			<li>
				<em>integer</em></li>
			<li>
				<em>numeric</em></li>
			<li>
				<em>array</em></li>
			<li>
				<em>enum</em> - Create attribute keys prefixed with &#39;enum:&#39; to define enumerated options. The portion of the string after &#39;enum:&#39; determines the valid key. The values of these atttributes are for labeling</li>
			<li>
				<em>regex</em> - Define a &#39;preg-match&#39; attribute as well containing the pattern required to match for validation</li>
			<li>
				<em>datetime</em> - Value must pass through php strtotime()</li>
		</ul>
	</li>
</ul>
<p>
	Pattern items may also include instructions for permissions on patterned items:</p>
<ul>
	<li>
		<strong>set-permission</strong> - String consisting of a list of permission rules to apply. Each rule is separated by a comma, each rule contains an &#39;[access_id]:[mode]&#39; pair.
		<ul>
			<li>
				ex: 0:5,-102:15 (Set &#39;World&#39; to read, insert and set group id 2 to read, write, insert, delete)</li>
		</ul>
	</li>
	<li>
		<strong>enable-insert</strong> - String consisting of a list of accessors that can insert this type of item. Each access id is separated by a comma. Access Ids described in record_tree2-&gt;chmod documentation.</li>
</ul>
',
                  ),
                ),
                'name' => 'validate($address,$data)',
                'description' => '<p>
	Determine if a write or insert at the specified address with the given data is valid according to any pattern attributes in place.</p>
',
                'return' => 'True on success, False on failure',
              ),
              'rebuild_permissions' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'name' => 'rebuild_permissions($address=\'/\',$depth=true)',
                'description' => '<p>
	Process any &#39;set-permissions&#39; attributes in found items.</p>
',
                'return' => 'True on success, False on failure.',
              ),
            ),
            'name' => 'tree_pattern',
            'description' => 'Apply patterns to data trees',
          ),
          'user_user' => 
          array (
            'pattern:match' => '/patterns/documentation/module-list/module',
            'node:owner' => '1',
            'node:children' => 
            array (
              'change_pw' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'eapmqoeonp' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$id',
                    'type' => 'Integer',
                    'description' => '<p>
	User ID to update</p>
',
                  ),
                  'cxylrcsdyz' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$old_pw',
                    'type' => 'String/False',
                    'description' => '<p>
	Pass a string to validate the old password or false to bypass this step</p>
',
                  ),
                  'okeufiyzzq' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$new_pw',
                    'type' => 'String',
                    'description' => '<p>
	New password for this user</p>
',
                  ),
                ),
                'name' => 'change_pw($id,$old_pw,$new_pw)',
                'description' => '<p>
	Change a user&#39;s password, optionally validating the old password</p>
',
                'return' => 'True on success, False on failure',
              ),
              'find_group_id' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'name' => 'find_group_id($groupName)',
                'description' => '<p>
	Find the ID based on a group name</p>
',
                'return' => 'Integer on success, False on failure',
              ),
              'find_id' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'xvlqeoyfrt' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$name',
                    'type' => 'String',
                    'description' => '<p>
	User name to search for</p>
',
                  ),
                ),
                'name' => 'find_id($name)',
                'description' => '<p>
	Get the id for a given user name</p>
',
                'return' => 'Integer on success, false on failure',
              ),
              'find_name' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'fxjahaacnp' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$id',
                    'type' => 'Integer',
                    'description' => '<p>
	User ID value to get name (default: false, current user)</p>
',
                  ),
                ),
                'name' => 'find_name($id=false)',
                'description' => '<p>
	Find the name of a user based on the ID</p>
',
                'return' => 'String on success, False on failure',
              ),
              'in_group' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'pztqotzsxc' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$groupName',
                    'type' => 'String',
                    'description' => '<p>
	Group to check user against membership</p>
',
                  ),
                  'dnrkegnjyb' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$userId',
                    'type' => 'Integer',
                    'description' => '<p>
	Specific user ID to check for membership (default: false, current user)</p>
',
                  ),
                  'uejveoqyyh' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Place in a config.ini [post] section to check if the current user is a member of the \'Administrators\' group',
                    'code' => 'check_admin[]="user_user/in_group/Administrators"',
                  ),
                ),
                'name' => 'in_group($groupName,$userId=false)',
                'description' => '<p>
	Determine if user is in a group, useful for config.ini post sections</p>
',
                'return' => 'True/False',
              ),
              'load_groups' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'efaipmhufv' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$attach',
                    'type' => 'Boolean',
                    'description' => '<p>
	Set to true to set $this-&gt;groups to the current group setting instead of returning the value (default: false)</p>
',
                  ),
                ),
                'name' => 'load_groups($attach=false)',
                'description' => '<p>
	Load the user groups and organize them into arrays. Not required, use $this-&gt;groups variable instead to prevent extra queries and processing.</p>
',
                'return' => 'Array on success, False on Failure',
              ),
              'logged_in' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'uejveoqyyh' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/example',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'description' => 'Place in a config.ini [post] section to check if user is logged in',
                    'code' => 'check_logged_in[]="user_user/logged_in"',
                  ),
                ),
                'name' => 'logged_in()',
                'description' => '<p>
	Used for form post validation to check if the browser is logged in</p>
',
                'return' => 'True/False',
              ),
              'login' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'nqdvfzrtfw' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$name',
                    'type' => 'String',
                    'description' => '<p>
	User name for log in</p>
',
                  ),
                  'pnsveqitob' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$pw',
                    'type' => 'String',
                    'description' => '<p>
	Plain text password to be checked against the hash</p>
',
                  ),
                ),
                'name' => 'login($name,$pw)',
                'description' => '<p>
	Login as a specific user and return the user ID</p>
',
                'return' => 'Integer on success, False on failure',
              ),
              'logout' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                ),
                'name' => 'logout()',
                'description' => '<p>
	Logout of current user session</p>
',
                'return' => 'True',
              ),
              'signup' => 
              array (
                'pattern:match' => '/patterns/documentation/module-list/module/function',
                'node:owner' => '1',
                'node:children' => 
                array (
                  'nqdvfzrtfw' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$name',
                    'type' => 'String',
                    'description' => '<p>
	User name for new user</p>
',
                  ),
                  'pnsveqitob' => 
                  array (
                    'pattern:match' => '/patterns/documentation/module-list/module/function/parameter',
                    'node:owner' => '1',
                    'node:children' => 
                    array (
                    ),
                    'name' => '$pw',
                    'type' => 'String',
                    'description' => '<p>
	Plain text password to be hashed for storage</p>
',
                  ),
                ),
                'name' => 'signup($name,$pw)',
                'description' => '<p>
	Create a new user and return the user ID</p>
',
                'return' => 'Integer on success, False on failure',
              ),
            ),
            'name' => 'user_user',
            'description' => 'Manage users and their passwords',
          ),
        ),
        'title' => 'Modules',
        'description' => 'All code is organized into modules which interact with each other using the root $node object.',
      ),
      'shell' => 
      array (
        'hide-menu' => '1',
        'node:owner' => '1',
        'node:children' => 
        array (
          'dpoixxojpy' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Data Manager',
            'section' => '<p>
	Like a typical file explorer, the data manager allows you to set key=&gt;values on items as well as their access rules. This display is cusomized based on the available permissions per item.</p>
<h3>
	Keyboard Shortcuts</h3>
<ul>
	<li>
		<code>escape</code> - Toggle Browser</li>
	<li>
		<code>backspace</code> - Up One Level</li>
	<li>
		<code>ctrl+i</code> - Insert Into</li>
	<li>
		<code>ctrl+del</code> - Delete</li>
	<li>
		<code>f2</code> - Rename</li>
	<li>
		<code>f4</code>&nbsp;- Focus Address Bar</li>
	<li>
		<code>ctrl+m</code> - Move/Copy</li>
</ul>
',
          ),
          'isiybcqsbr' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'User Manager',
            'section' => '<p>
	Manage users and groups using simple tools</p>
',
          ),
          'wqxbfdnscv' => 
          array (
            'pattern:match' => '/patterns/documentation/page/section',
            'node:owner' => '1',
            'node:children' => 
            array (
            ),
            'title' => 'Terminal',
            'section' => '<p>
	Directly run PHP commands through a terminal interface in the browser.</p>
<p>
	Example - Display items at root of data tree:</p>
<pre>
print_r($this-&gt;tree-&gt;get(&#39;/&#39;,0));</pre>
<p>
	Command and local variable history are saved in the user&#39;s home item.</p>
<p>
	Config.ini terminal save history settings:</p>
<pre>
[front]
;save terminal history to user&#39;s home item instead of just session
save_terminal_history=true|false 
;number of terminal commands to save
save_terminal_commands=[integer] 
</pre>
<p>
	Perform operations on your site without needing to build test pages.</p>
<p>
	Learn new ways to make your functions and classes interact by trying out different calls.</p>
',
          ),
        ),
        'pattern:match' => '/patterns/documentation/page',
        'title' => 'Shell',
        'description' => 'Access data trees, modify users, permissions, and groups, and interact directly with the terminal.',
        'content' => '<p>
	This application included with the framework provides the basis for interacting with your site. Only users with ownership on the root have the ability to edit users/groups and use the terminal in the shell.</p>
',
      ),
      'haml-sass' => 
      array (
        'pattern:match' => '/patterns/documentation/page',
        'node:owner' => '1',
        'node:children' => 
        array (
        ),
        'title' => 'Using HAML & SASS',
        'description' => 'Learn how to speed up templating HTML views as well as simplify coding out CSS.',
        'content' => '<p>
	This framework employs <a href="http://code.google.com/p/phamlp/" target="_blank">Google&#39;s PHamlP</a> implementation the standard Ruby <a href="http://haml.info/" target="_blank">HAML</a>&nbsp;translators.</p>
<p>
	The Haml library included with this framework has been modified slightly to also allow PHP function() declarations inside of a HAML document, thereby allowing recursion in templates without multiple templates.</p>
<p>
	For tranlating SCSS files, <a href="http://leafo.net/scssphp/">SCSSPHP</a> has been included as another option to PHamlP. Media query support makes SCSSPHP a good choice.</p>
',
        'hide-menu' => '1',
      ),
    ),
    'admin:icon' => 'book',
  ),
);