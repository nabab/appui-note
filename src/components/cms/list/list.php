<!-- HTML Document -->
<div :class="['bbn-overlay', componentClass]">
  <bbn-table ref="table"
             :source="root + 'cms/list'"
             :limit="25"
             :info="true"
             :storage="true"
             :selection="true"
             :pageable="true"
             :showable="true"
             :sortable="true"
             :filterable="true"
  					 :toolbar="$options.components['toolbar']">
    <bbns-column title=" "
                 :component="$options.components.menu"
                 :filterable="false"
                 :showable="false"
                 :sortable="false"
                 :width="30"
                 cls="bbn-c"/>
    <bbns-column field="id"
                 :hidden="true"
                 :min-Width="130"
                 title="<?= _("ID") ?>"/>
    <bbns-column field="title"
                 :min-Width="250"
                 title="<?= _("Title") ?>"/>
    <bbns-column field="url"
                 title="<?= _("URL") ?>"
                 :min-Width="200"
                 :render="renderUrl"/>
    <bbns-column field="id_user"
                 title="<?= _("Creator") ?>"
                 :width="200"
                 :source="users"/>
    <bbns-column field="excerpt"
                 :hidden="true"
                 :width="250"
                 title="<?= _("Excerpt") ?>"/>
    <!--bbns-column field="content"
                 title="<?= _("Content") ?>"
                 :filterable="false"
                 :render="renderContent"/-->
    <bbns-column field="creation"
                 type="date"
                 :width="120"
                 title="<?= _("Creation") ?>"/>
    <bbns-column field="start"
                 type="date"
                 :width="120"
                 title="<?= _("Publication") ?>"/>
    <bbns-column field="end"
                 type="datetime"
                 :width="120"
                 title="<?= _("End") ?>"/>
    <bbns-column :width="80"
                 field="version"
                 title="<?= _("Version") ?>"
                 cls="bbn-c"/>
    <bbns-column field="num_medias"
                 :width="50"
                 title="<i class='nf nf-fa-file_photo_o'> </i>"
                 ftitle="<?= _("Number of medias associated with this entry") ?>"
                 type="number"
                 cls="bbn-c"/>
  </bbn-table>
</div>
