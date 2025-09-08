<bbn-form class="appui-note-masks-warning bbn-padding bbn-c"
          :buttons="[{
            label: _('Ok'),
            action: close,
            cls: 'bbn-primary'
          }]">
  <div class="bbn-b bbn-lg bbn-bottom-space">Attention!</div>
  <div class="bbn-bottom-space">
    <!-- Ici vous pouvez modifier les lettres types mais elles utilisent un système de "templates" avec lequel il vous faut être très précautionneux. -->
     <?=_("Here you can modify the standard letters but they use a system of \"templates\" with which you must be very careful.")?>
  </div>
  <div>
    <!--"Le mieux est de dupliquer une lettre-type existante et de la modifier. Une fois terminée, mettez-là en défaut si elle est utilisée sur une fonctionnalité sans choix (ex: attestations), et allez la tester dans son contexte. Alors vous pourrez effacer l'ancienne ou bien la refaire passer en défaut si votre modification renvoie une erreur.-->
    <?=_("The best is to duplicate an existing standard letter and modify it. Once finished, put it in default if used on a functionality without choice (ex: certificates), and go and test it in context. So you can erase the old or go back to default if your modification returns an error.")?>
  </div>
  <div class="bbn-middle bbn-top-lmargin">
    <bbn-switch bbn-model="doNotShowAgain"
                :value="true"
                :novalue="false"
                class="bbn-right-sspace"/>
    <div class="bbn-p"
         @click="doNotShowAgain = !doNotShowAgain">
      <?=_("No longer ask for the future")?>
    </div>
  </div>
</bbn-form>