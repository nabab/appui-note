// Javascript Document

(()=> {
  const fn = (arr, res = []) => {
    bbn.fn.each(arr, a => {
      if (a.url) {
        res.push({
          cover: a.cover ||"",
          description: a.description || "",
          id: a.id,
          id_screenshot: a.id_screenshot || null,
          screenshot_path: a.screenshot_path || "",
          text: a.text,
          url:a.url
        })
      }
      else if (a.items) {
        fn(a.items, res);
      }
    });
    return res;
  };
  return {
    props: {
    },
    data() {
      return {
        root: appui.plugins['appui-note'] + '/',
        checkTimeout: 0,
        delId: "",
        idParent: "",
        currentNode: null,
        showGallery: false,
        visible: false,
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
        drag: true,
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
      openUrl() {
        bbn.fn.log("SOURCE", this.currentSource);
        if (this.currentData.id) {
          window.open(this.root + "actions/bookmarks/go/" + this.currentData.id, this.currentData.id);
        }
        else {
          window.open(this.currentData.url, this.currentData.title);
        }
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
              bbn.fn.log("d", d);
              if (d.success) {
                this.currentData.count = d.count;
              }
            }
          );
        }
      },
      getData () {
        this.currentSource = [];
        bbn.fn.post(this.root + "actions/bookmarks/data", d => {
          this.currentSource = d.data;
        });
        bbn.fn.log("currentSource : ", this.$emit.dragOver);
      },
      resetform() {
        this.currentData = {
          url: "",
          title: "",
          image: "",
          description: "",
          id: null,
          images: [],
          cover: null,
          id_screenshot: ""
        };
        this.idParent = "";
      },
      add() {
        bbn.fn.log(this, "this")
        bbn.fn.post(
          this.root + "actions/bookmarks/add",
          {
            url: this.source.url,
            description: this.source.description,
            title: this.source.title,
            id_parent:  this.source.idParent,
            cover: this.source.cover,
          },  d => {
            if (d.success) {
              bbn.fn.log(d);
              this.source.id = d.id_bit;
              this.source.count = 0;
              appui.success();
              this.getData();
              this.screenshot();
            }
          });
      },
      deletePreference() {
        bbn.fn.post(
          this.root + "actions/bookmarks/delete",
          {
            id: this.currentData.id
          },  d => {
            if (d.success) {
              this.getData();
            }
          });
        return;
      },
      modify() {
        bbn.fn.post(this.root + "actions/bookmarks/modify", {
          url: this.source.url,
          description: this.source.description,
          title: this.source.title,
          id: this.source.id,
          cover: this.source.cover,
          screenshot_path: this.source.screenshot_path,
          id_screenshot: this.source.id_screenshot,
        },  d => {
          if (d.success) {
            this.getData();
          }
        });
      },
      contextMenu(bookmark) {
        return [
          {
            text: bbn._("Edit"),
            icon: "nf nf-fa-edit",
            action: () => {
              this.getPopup({
                component: "appui-note-bookmarks-form",
                componentOptions: {
                  source: bookmark
                }
              });
            }
          }
        ];
      },
    },
    mounted() {
      let sc = this.getRef("scroll");
      this.getData();
    },
    watch: {
      currentNode(v) {
        if (v) {
          bbn.fn.log("v", v);
          this.currentData = {
            url: v.data.url || "",
            title: v.data.text || "",
            description: v.data.description || "",
            id: v.data.id || "",
            cover: v.data.cover || null,
            id_screenshot: v.data.id_screenshot || "",
            screenshot_path: v.data.screenshot_path || "",
            count: v.data.count || 0
          };
        }
        else {
          this.resetForm();
        }
      },
    }
  }
})();