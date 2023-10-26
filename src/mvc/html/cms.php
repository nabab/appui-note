<!-- HTML Document -->

<bbn-router :nav="true">
  <bbn-container url="home"
                 fcolor="#FFF"
                 bcolor="#063B69"
                 :static="true"
                 :source="source"
                 component="appui-note-cms-dashboard"
                 :title="_('Home')"
                 icon="nf nf-md-home"
                 :notext="true"/>
  <bbn-container url="posts"
                 :static="true"
                 :source="source"
                 component="appui-note-cms-list"
                 :title="_('Posts')"
                 icon="nf nf-md-format_list_text"
                 :notext="true"
                 fcolor="#FFF"
                 bcolor="#063B69"/>
</bbn-router>
