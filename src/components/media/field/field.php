<!-- HTML Document -->

<div :class="componentClass">
  <div class="bbn-w-100 bbn-flex">
    <div class="bbn-right-margin">
      <div class="bbn-iblock bbn-bottom-smargin">
        <bbn-button icon="nf nf-fae-galery"
                    :notext="true"
                    @click="openGallery"
                    title="<?=_('Browse the images')?>"/>
      </div><br>
      <div class="bbn-iblock bbn-bottom-smargin">
        <bbn-button v-if="currentIndex > -1"
                    icon="nf nf-mdi-information_outline"
                    :notext="true"
                    @click="openInfo(source[currentIndex])"
                    title="<?=_('Show media information')?>"/>
      </div>
    </div>
    <div>
      <img v-if="value"
           class="bbn-bordered bbn-radius"
           style="max-height: 8em; width: min(auto, 100%); max-width: 8em; height: min(auto, 100%)"
           :src="root + 'media/image/' + value + '?w=200'">
    </div>
  </div>
  <div v-if="source.length"
       class="bbn-w-100 bbn-flex"
       style="flex-wrap: wrap">
    <div v-for="(img, i) in source"
         class="bbn-spadded bbn-p"
         @click="emitInput(img.id)"
         @mouseenter="overImg = img.id"
         @mouseleave="overImg = null"
         :style="{minWidth: '5em', minHeight: '5em', paddingLeft: i ? null : '0px', paddingRight: i < source.length - 1 ? null : '0px'}">
      <div class="bbn-100 bbn-vmiddle">
        <img class="bbn-bordered bbn-radius"
             style="max-height: 5em; width: min(auto, 100%); max-width: 5em; height: min(auto, 100%)"
             :src="root + 'media/image/' + img.id + '?w=200'">
        <div class="bbn-bottom-left bbn-w-100 bbn-modal bbn-white bbn-c"
             style="height: 1.5em"
             v-show="overImg === img.id"
             @click.stop>
          <div class="bbn-iblock bbn-xspadded bbn-p bbn-text-reactive"
               @click="() => {}">
            <i class="nf nf-mdi-magnify_plus_outline"/>
          </div>
          <div class="bbn-iblock bbn-xspadded bbn-p bbn-text-reactive"
               @click="openInfo(img)">
            <i class="nf nf-mdi-information"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
