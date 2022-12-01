<!-- HTML Document -->

<div class="bbn-bg-white bbn-flex bbn-padding"
     style="flex-direction: column">
  <div class="bbn-flex"
       style="justify-content: space-around; text-align: center;">
    <div class="bbn-40 bbn-spadding bbn-flex"
         :style="[selected ? {'border': '1px solid orange'} : {'border': '1px solid gray'}, {'flex-direction': 'column'}, {'cursor': 'pointer'}]"
         @click="changeSelect(true)">
      <i class="nf nf-mdi-content_save bbn-xxl bbn-webblue"/>
      <span>Save original</span>
    </div>
    <div class="bbn-40 bbn-spadding bbn-flex"
         :style="[selected ? {'border': '1px solid gray'} : {'border': '1px solid orange'}, {'flex-direction': 'column'}, {'cursor': 'pointer'}]"
         @click="changeSelect(false)">
      <i class="nf nf-mdi-content_save_settings bbn-xxl bbn-webblue"/>
      <span>Save as new file</span>
    </div>
  </div>
  <div class="bbn-top-lmargin">
    <bbn-input :required="true"
               :readonly="selected"
               placeholder="filename"
               :value="fileInfo.name"
               @change="updateFileName"
               />
    <bbn-dropdown class="bbn-narrow"
                  :readonly="selected"
                  v-model="extension"
                  :source="[
                           {text: '.png', value: 'png'},
                           {text: '.jpg', value: 'jpg'},
                           {text: '.jpeg', value: 'jpeg'},
                           {text: '.webp', value: 'webp'}
                           ]">
    </bbn-dropdown>
    <div class="bbn-top-margin">
      <label>Resize</label>
      <div class="bbn-flex bbn-top-smargin"
           style="align-items: center">
        <bbn-numeric class="bbn-w-20 bbn-right-smargin"
                   :value="height ? height : 0"
                   placeholder="#"
                   @change="updateHeight"
                   />
        <span class="bbn-right-spadding">X</span>
        <bbn-numeric class="bbn-w-20 bbn-right-smargin"
                   :value="width ? width : 0"
                   placeholder="#"
                   @change="updateWidth"
                   />
        <i v-bind:class="[locked ? 'nf nf-fa-lock' : 'nf nf-fa-unlock_alt', 'bbn-center']"
           @click="lockSize"/>
        <i class="nf nf-mdi-backup_restore bbn-center bbn-left-spadding bbn-xl"
           @click="resetSize"/>
      </div>
    </div>
  </div>
  <div class="bbn-top-lmargin"
       style="margin-inline: auto;">
    <bbn-button text="Cancel"
                @click="cancel"/>
    <bbn-button text="Save"
                class="bbn-bg-webblue"
                @click="saveImage"/>
  </div>
</div>
