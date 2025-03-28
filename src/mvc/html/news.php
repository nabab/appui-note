<bbn-table :source="source.root + 'data/news'"
           :pageable="true"
           ref="table"
           :info="true"
           :limit="25"
           :toolbar="[{
             text: '<?= _('New message') ?>',
             icon: 'nf nf-fa-plus',
             action: insert
           }]"
           :editable="true"
           :editor="$options.components['appui-note-news-new']"
           :data="{
             type: source.type
           }"
           :filterable="true"
>
  <bbns-column :invisible="true"
               field="id_note"
               :editable="false"
               :filterable="false"
  ></bbns-column>
  <bbns-column field="title"
               label="<i class='nf nf-fa-newspaper_o bbn-xl'></i>"
               flabel="<?= _("Title") ?>"
  ></bbns-column>
  <bbns-column field="id_user"
               label="<i class='nf nf-fa-user bbn-xl'></i>"
               flabel="<?= _("Author") ?>"
               :width="300"
               :source="users"
  ></bbns-column>
  <bbns-column field="content"
               label="<i class='nf nf-fa-comment bbn-xl'></i>"
               flabel="<?= _("Text") ?>"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="creation"
               label="<i class='nf nf-fa-calendar bbn-xl'></i>"
               flabel="<?= _("Creation date") ?>"
               :width="120"
               type="date"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column field="start"
               label="<i class='nf nf-fa-calendar_check_o bbn-xl'></i>"
               flabel="<?= _("Start date") ?>"
               :width="120"
               type="date"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column field="end"
               label="<i class='nf nf-fa-calendar_times_o bbn-xl'></i>"
               flabel="<?= _("End date") ?>"
               :width="120"
               type="date"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column :width="100"
               cls="bbn-c"
               flabel="<?= _("Actions") ?>"
               :buttons="[{
                 action: see,
                 icon: 'nf nf-fa-eye',
                 text: '<?= _("See") ?>',
                 notext: true
               }, {
                 action: edit,
                 icon: 'nf nf-fa-edit',
                 text: '<?= _("Mod.") ?>',
                 notext: true
               }]"
               :filterable="false"
  ></bbns-column>
</bbn-table>


<script type="text/x-template" id="appui-note-news-new">
  <bbn-form class="bbn-lpadding"
            :source="source.row"
            :data="source.data"
            ref="form"
            :action="root + '/actions/' + ( source.row.id_note ? 'update' : 'insert')"
            @success="success"
            :validation="checkDate"
  >    
    <div class="bbn-grid-fields bbn-lpadding">
      <label>
        <?= _("Title") ?>
      </label>
      <bbn-input required="required"
                 bbn-model="source.row.title"
      ></bbn-input>
      <label>
        <?= _("Publication date") ?>
      </label>
      <div>
        <bbn-datetimepicker bbn-model="source.row.start"
                            required="required"
        ></bbn-datetimepicker>
      </div>
      <label>
        <?= _("End date") ?>
      </label>
      <div>
        <bbn-datetimepicker bbn-model="source.row.end"
                            :min="source.row.start"
        ></bbn-datetimepicker>
      </div>
      <label>
        <?= _("Text") ?>
      </label>
      <div style="overflow: inherit; height: 400px">
        <bbn-rte bbn-model="source.row.content"
                 required="required"
        ></bbn-rte>
      </div>
    </div>   
  </bbn-form>
</script>