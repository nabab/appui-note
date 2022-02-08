// Javascript Document

(() => {
  return {
    props: {
      source: {}
    },
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
        currentData: {
          url: "",
          title: "", //input
          image: "",
          description: "", //textarea
          id: null,
          images: [],
          image: "",
          screenshot_path: "",
          id_screenshot: "",
          count: 0,
        },
        currentSource: [],
      }
    },
    computed: {
      blockSource() {
        let res = [];
        if (this.currentSource.length) {
          res = fn(this.currentSource);
        }
        return res;
      },
    },
    methods: {
      openEditor(bookmark) {
        this.getPopup({
          component: "appui-note-bookmarks-form",
          componentOptions: {
            source: bookmark
          },
          title: bookmark.id ? bbn._("Edit Form") : bbn._("New Form")
        });
      },
      newform() {
        this.openEditor({});
      },
      contextMenu(bookmark) {
        bbn.fn.log(bookmark);
        return [
          {
            text: bbn._("Edit"),
            icon: "nf nf-fa-edit",
            action: () => {
              this.openEditor(bookmark)
            }
          },
          {
            text: bbn._("Delete"),
            icon: "nf nf-mdi-delete",
            action: () => {
              this.deletePreference(bookmark);
            }
          }
        ];
      },
      deletePreference(bookmark) {
        bbn.fn.post(
          this.root + "actions/bookmarks/delete",
          {
            id: bookmark.id
          },  d => {
            if (d.success) {
              this.getData();
            }
          });
        return;
      },
      getData () {
        this.currentSource = [];
        bbn.fn.post(this.root + "actions/bookmarks/data", d => {
          this.currentSource = d.data;
        });
      },
      openUrlSource(source) {
        bbn.fn.log("source", source);
        if (source.url) {
          window.open(source.url, source.text);
          bbn.fn.post(
            this.root + "actions/bookmarks/count",
            {
              id: source.id,
            },
            d => {
              if (d.success) {
                this.currentData.count = d.count;
              }
            }
          );
        }
      },
    },
  }
})();