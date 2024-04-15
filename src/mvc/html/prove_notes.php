<div class="bbn-100">
  <bbn-tree :source="{data: source.prove_notes}"
  >
  </bbn-tree>>
</div>
  <!--table class="ui celled padded table">
    <thead>
      <tr>
        <th>id</th>
        <th>id parent</th>
        <th>titolo</th>
        <th>medias</th>
        <th>num_children</th>
        <th>isFolder</th>
      </tr>
    </thead>
    <tbody>
      <tr bbn-for="n in prove_notes">
        <td bbn-text="n.id"></td>
        <td bbn-text="n.id_parent"></td>
        <td bbn-text="n.title ? n.title : 'No Title'" id="title">{{colorText}}</td>
        <td bbn-text="n.medias"></td>
        <td bbn-text="n.num_children"></td>
        <td bbn-text="(!n.medias) || (n.num_children) ? 'isFolder' : ''" ></td>
      </tr>
    </tbody>
  </table-->