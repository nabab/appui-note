/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 18/07/17
 * Time: 17.26
 */


(() => {
  let filterTimeout;
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      return {
        editedNote: false,
        choosing:false,
        filterString: '',
        currentFolder: null,
        currentFilter: {logic: 'AND', conditions: []},
        toolbarButtons: [{
          text: bbn._("Create new folder"),
          icon: 'nf nf-md-plus_thick',
          notext: true,
          action: () => this.createFolder()
        }, {
          text: bbn._("Reload the folders list"),
          icon: 'nf nf-md-refresh',
          notext: true,
          action: () => this.refreshFolder()
        }],
        newPostIt: null
      };
    },
    methods: {
      onRegisterNode(node) {
        node.setAttribute('data-bbn_droppable', 'true');
      },
      onUnselect(node, e) {
        if (this.getRef('list').isLoading) {
          e.preventDefault();
          return;
        }

        if (this.currentFolder === node.data.id) {
          this.currentFolder = null;
        }
      },
      onSelect(node, e) {
        if (this.getRef('list').isLoading) {
          e.preventDefault();
          return;
        }

        if (this.currentFolder !== node.data.id) {
          this.currentFolder = node.data.id;
        }
      },
      onDrop() {
        bbn.fn.log('onDrop', arguments);
      },
      onDragEnd(e) {
        if (e.detail.from?.target) {
          bbn.fn.log(["ORIGIN: ", e.target, "TARGET", e.detail.from.target.closest('li[data-bbn_droppable=true]')]);
        }
      },
      onMove(node, target, ev) {
        if (node?.data && target?.data && (node.data.id_parent !== target.data.id) && (node.data.id !== target.data.id_parent) && (node.data.id !== target.data.id)) {
          bbn.fn.post(appui.plugins['appui-note'] + '/folders/move', {
            id: node.data.id,
            parent: target.data.id
          }, d => {
            if (d.success) {
              bbn.fn.log("SUCCCCCC", d)
            }
            else {
              ev.preventDefault();
            }
          })
          bbn.fn.log(['onMove', arguments])
        }
      },
      startloading() {
        bbn.fn.log('startloading')
      },
      datareceived() {
        bbn.fn.log('datareceived')
      },
      folderMenu(item) {
        return [{
          text: bbn._("Create new folder"),
          icon: 'nf nf-md-plus_thick',
          notext: true,
          action: () => this.createFolder(item)
        }, {
          text: bbn._("Reload the folders list"),
          icon: 'nf nf-md-refresh',
          notext: true,
          action: () => this.refreshFolder(item)
        }];
      },
      createFolder(item) {
        this.getPopup({
          label: false,
          component: 'appui-note-popup-folder',
          componentOptions: {
            id_parent: item ? item.data.id : null
          },
          events: {
            success: e => bbn.fn.log("MYSUCCESS", e)
          }
        })
      },
      refreshFolder(item) {
        if (item) {
          return item.tree.reload();
        }

        return this.getRef('tree').reload();
      },
      add() {
        this.newPostIt = this.getNewPostIt();
        this.$forceUpdate();
      },
      isEditing(val){
        bbn.fn.log(val);
        return val === this.editedNote;
      },
      getNewPostIt() {
        return {
          text: bbn._("Write here your content"),
          label: bbn._("Don't forget!"),
          date: bbn.fn.dateSQL(),
          bcolor: '#fbf7ae',
          fcolor: '#000000'
        };
      },
      onSave(postit) {
        if (postit && postit.id) {
          bbn.fn.log(postit, "YEAH TO DO!");
          return;
          let row = bbn.fn.getRow(this.source.notes, {id: postit.id});
          if (row) {
            bbn.fn.extend(row, postit);
          }
          else {
            this.source.notes.unshift(postit);
          }
        }
      },
      onFilter() {
        this.currentFilter.conditions.splice(0);
        const filter = {
          logic: 'OR',
          conditions: []
        };
        if (this.filterString) {
          filter.conditions.push(
            {field: 'title', operator: 'contains', value: this.filterString},
            {field: 'content', operator: 'contains', value: this.filterString},
          );
        }
        if (this.currentFolder) {
          this.currentFilter.logic = 'AND';
          this.currentFilter.conditions.push({field: 'id_parent', operator: '=', value: this.currentFolder});
          if (this.filterString) {
            this.currentFilter.conditions.push(filter);
          }
        }
        else if (this.filterString) {
          this.currentFilter = filter;
        }

        this.getRef('list').updateData();
        
      }
    },
    created() {
    },
    watch: {
      filterString(v, ov) {
        if (filterTimeout) {
          clearTimeout(filterTimeout);
        }

        filterTimeout = setTimeout(this.onFilter, 500);
      },
      num() {
        this.newPostIt = null;
      },
      currentFolder() {
        this.onFilter();
      }
    }
  }
})();

