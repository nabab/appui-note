<!-- HTML Document -->
<div class="bbn-overlay appui-note-cms">
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

<!--form for create new pge in note-->
<script type="text/x-template" id="form">
  <bbn-form ref="form"
            :action="url"
            :source="source"
            @success="afterSubmit"
            :data="{publish: publish}"
            :validation="validationForm"
            :prefilled="true"
  >
    <div class="bbn-overlay">
      <div class="bbn-grid-fields bbn-lpadded">
        <label class="bbn-b">
          <?=_('Title')?>
        </label>
        <bbn-input v-model="source.title"
                   required="required"
                   class="bbn-w-50"
                   @change="makeURL"
                   :required="true"
                   :readonly="source.action === 'publish'"
        ></bbn-input>
     
        <label class="bbn-b">
          <?=_('Publish')?>
        </label>
        <bbn-checkbox :value="true"
                      v-model="publish"
                      :novalue="false"
        ></bbn-checkbox>
        <label class="bbn-b" v-if="publish">
          <?=_('Pub. date')?>
        </label>
        <bbn-datetimepicker v-model="source.start"
                            class="bbn-w-20"
                            :nullable="true"
                            v-if="publish"
        ></bbn-datetimepicker>
        <label v-if="publish"
               class="bbn-b"
               v-text="_('End date') + ':'"
        ></label>
        <bbn-datetimepicker v-model="source.end"
                            class="bbn-w-20"
                            :min="source.start ? source.start : '' "
                            :nullable="true"
                            v-if="publish"
        ></bbn-datetimepicker>

        <label class="bbn-b"
               v-text="_('Url') + ':'"
        ></label>
        <bbn-input v-model="source.url"
                   class="bbn-w-100"
                   :readonly="source.action === 'publish'"
                   @keydown="adjustURL"
                   :required="true"
        ></bbn-input>
        <label v-text="_('Add media from gallery:')"
               class="bbn-b"
               >
  			</label>
        <div>
          <bbn-button icon="nf nf-mdi-attachment"
                      class="bbn-xl"
                      :notext="true"
                      @click="addMedia"
                      :title="_('Add a media from the media browser')"
          ></bbn-button>
  			</div>
				<div class="bbn-grid-full" v-if="source.files && source.files.length">
          <appui-note-media-preview v-for="(f, i) in source.files" 
                                     :data="f"
                                     :key="i"
          ></appui-note-media-preview>
        </div>
      </div>
      <div style="height:350px;" class="bbn-spadded">
        <bbn-rte v-model="source.content"
                 required="required"
                 style="height:350px;"
                 :iframe="true"
                 :readonly="source.action === 'publish'"
        ></bbn-rte>
      </div>
    </div>
  </bbn-form>
</script>