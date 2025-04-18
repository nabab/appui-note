<bbn-table class="bbn-w-100"
           ref="table"
           :source="root + 'table_notes'"
           :limit="25"
           :info="true"
           :pageable="true"
           :url="root + 'table_notes'"
           :sortable="true"
           :filterable="true"
           :editable="true"
           :toolbar="[{
                     text: 'Nouvel note',
                     icon: 'nf nf-fa-plus',
                     notext: false,
                     action: markdown
                     }]"
           :order="[{
                   field: 'last_edit',
                   dir: 'DESC'
                   }]">
  <bbns-column field="id_note"
               :editable="false"
               :invisible="true"/>

  <bbns-column field="title"
               :editable="false"
               label="<?= _("Title") ?>"
               :render="title"/>

  <bbns-column field="version"
               label="#"
               :editable="false"
               :width="50"
               cls="bbn-c"/>

  <bbns-column label="<?= _("Resume") ?>"
               :editable="false"
               :render="getResume"/>

  <bbns-column field="creator"
               :editable="false"
               label="<?= _("Creator") ?>"
               :source="users"
               :invisible="true"
               :width="160"/>

  <bbns-column field="id_user"
               :editable="false"
               label="<?= _("Last version user") ?>"
               :source="users"
               :invisible="true"
               :width="160"/>

  <bbns-column field="creation"
               :editable="false"
               label="<?= _("Creation") ?>"
               type="date"
               cls="bbn-c"
               :width="100"/>

  <bbns-column field="last_edit"
               :editable="false"
               label="<?= _("Last edit") ?>"
               type="date"
               :invisible="true"
               cls="bbn-c"
               :width="100"/>

  <bbns-column field="id_type"
               label="<?= _("Type") ?>"
               :render="getType"
               :source="source.options"
               :width="120"/>

  <bbns-column field="id_option"
               :editable="false"
               label="<?= _("Option") ?>"
               :render="getOption"
               :width="120"/>

  <bbns-column :width="90"
               label="<?= _("Actions") ?>"
               cls="bbn-c"
               :buttons="['edit']"/>

</bbn-table>

<script type="text/x-template" id="apst-notes-content">
<div style="height: 300px; margin-right:30px; position:relative">
  <input type="hidden" :value="source.id_notes">
  <div  bbn-html="source.content ? source.content : 'no content'" style="height:100%;
                                                                       width:100%"></div>
  </div>
</script>

<script type="text/x-template" id="apst-new-note">
<bbn-form :data="source"
          ref="form"
          confirm-leave="<?= _("Are you sure you want to leave this form without saving your changes?") ?>"
          :action="'adherent/actions/notes/' + ( source.id ? 'update' : 'insert')"
          :buttons="['submit', 'cancel', 'close']"
          @success="success"
          @failure="failure"
          >
  <div class="bbn-padding bbn-w-100" style="min-height: 500px">


    <label class="bbn-form-label">
      <?= _("Category") ?>
  </label>
    <div class="bbn-form-field">
      <bbn-dropdown name="id_type_note"
                    required="required"
                    bbn-model="source.id_type_note"
                    :source="options.notes"
                    ></bbn-dropdown>
  </div>

    <label class="bbn-form-label">
      <?= _("Text") ?>
  </label>
    <div class="bbn-form-field">
      <bbn-rte bbn-model="source.texte"
               name="texte"
               required="required"
               class="bbn-100"
               >
  </bbn-rte>
  </div>

    <label class="bbn-form-label" bbn-if="isOwner">
      <?= _("Blocked") ?>
  </label>
    <div class="bbn-form-field" bbn-if="isOwner">
      <bbn-checkbox bbn-model="source.confidentiel"
                    name="confidentiel"
                    id="t4Wo9nnuXZb4wXifPahWB"
                    :checked="source.confidentiel ? true : false"
                    ></bbn-checkbox>
  </div>
  </div>
  </bbn-form>
</script>