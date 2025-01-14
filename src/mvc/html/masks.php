<!-- HTML Document -->

<bbn-table :source="source.data"
           class="appui-note-masks-table"
           editable="popup"
           ref="table"
           :url="source.root + 'actions/mask/update'"
           :order="[{text:'ASC'}]"
           :groupable="true"
           :group-by="3"
           >
  <bbns-column :label="_('ID')"
              field="id_note"
              :width="100"
              :invisible="true"
              :editable="false"
              ></bbns-column>
  <bbns-column :label="_('Default')"
              field="default"
              cls="bbn-c"
              :width="50"
              :component="$options.components.def"
              :editable="false"
              ></bbns-column>
  <bbns-column :label="_('Version')"
              field="version"
              type="number"
              :width="50"
              :editable="false"
              ></bbns-column>
  <bbns-column :label="_('Letter\'s type')"
              field="id_type"
              :editable="false"
              :component="$options.components.cat"
              ></bbns-column>
  <bbns-column :label="_('Name')"
               field="name"
  ></bbns-column>
  <bbns-column :label="_('Subject')"
              field="title"
              ></bbns-column>
  <bbns-column :label="_('Last change')"
              field="creation"
              :editable="false"
              type="date"
              :width="120"
              ></bbns-column>
  <bbns-column :label="_('User')"
              field="id_user"
              :editable="false"
              :width="150"
              :render="renderUser"
              ></bbns-column>
  <bbns-column :label="_('Text')"
              field="content"
              editor="bbn-rte"
              :invisible="true"
              ></bbns-column>
  <bbns-column width='160'
              :label="_('Actions')"
              :buttons="getButtons"></bbns-column>

</bbn-table>