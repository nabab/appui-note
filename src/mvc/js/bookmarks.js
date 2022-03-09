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
          url: a.url,
          clicked: a.clicked || 0
        });
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
          screenshot_path: "",
          id_screenshot: "",
          clicked: 0,
        },
        currentSource: [],
        drag: true,
      };
    },
    computed: {
      blockSource() {
        let res = [];
        if (this.source.data.length) {
					res = fn(this.source.data);
        }
        return res;
      },
    },
    methods: {
      showScreenshot() {
        this.visible = true;
      },
      updateWeb() {
        this.showGallery = true;
        bbn.fn.post(
          this.root + "actions/bookmarks/preview",
          {
            url: this.currentData.url,
          },
          d => {
            if (d.success) {
              if (d.data.images) {
                this.currentData.images = bbn.fn.map(d.data.images, (a) => {
                  return {
                    content: a,
                    type: 'img'
                  };
                });
              }
            }
            return false;
          }
        );
      },
      openUrl() {
        if (this.currentData.id) {
          window.open(this.root + "actions/bookmarks/go/" + this.currentData.id, this.currentData.id);
        }
        else {
          window.open(this.currentData.url, this.currentData.title);
        }
      },
      openUrlSource(source) {
        if (source.url) {
          window.open(source.url, source.text);
          bbn.fn.post(
              this.root + "actions/bookmarks/count",
              {
                id: source.id,
              },
              d => {
                if (d.success) {
                  this.currentData.clicked++;
                }
              }
            );
        }
      },
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
        return [
          {
            text: bbn._("Edit"),
            icon: "nf nf-fa-edit",
            action: () => {
              this.openEditor(bookmark);
            }
          }
        ];
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
      isDragEnd(event, nodeSrc, nodeDest) {
        if (nodeDest.data.url) {
          event.preventDefault();
        }
        else {
          bbn.fn.post(this.root + "actions/bookmarks/move", {
            source: nodeSrc.data.id,
            dest: nodeDest.data.id
          }, d => {
          });
        }
      },
      checkUrl() {
        if (!this.currentData.id && bbn.fn.isURL(this.currentData.url)) {
          bbn.fn.post(
            this.root + "actions/bookmarks/preview",
            {
              url: this.currentData.url,
            },
            d => {
              if (d.success) {
                this.currentData.title = d.data.title;
                this.currentData.description = d.data.description;
                this.currentData.cover = d.data.cover ||null;
                if (d.data.images) {
                  this.currentData.images = bbn.fn.map(d.data.images, (a) => {
                    return {
                      content: a,
                      type: 'img'
                    };
                  });
                }
              }
              return false;
            }
          );
        }
      },
      selectTree(node) {
        this.currentNode = node;
        if (this.currentNode.data.id) {
          this.$nextTick(() => {
            bbn.fn.post(
              this.root + "actions/bookmarks/count",
              {
                id: this.currentNode.data.id,
              },
              d => {
                if (d.success) {
                  this.currentData.clicked++;
                }
              }
            );
          });
        }
      },
      screenshot() {
        bbn.fn.post(
          this.root + "actions/bookmarks/screenshot",
          {
            url: this.currentData.url,
            title: this.currentData.title,
            id: this.currentData.id
          },
          d => {
            if (d.success) {
              this.currentData.screenshot_path = d.data.screenshot_path;
              this.currentData.id_screenshot = d.data.id_screenshot;
            }
          }
        );
      },
      add() {
        bbn.fn.post(
          this.root + "actions/bookmarks/add",
          {
            url: this.currentData.url,
            description: this.currentData.description,
            title: this.currentData.title,
            id_parent:  this.idParent,
            cover: this.currentData.cover,
          },  d => {
            if (d.success) {
              this.currentData.id = d.id_bit;
              this.currentData.clicked++;
              appui.success();
              this.screenshot();
            }
          });
      },
      selectImage(img) {
        this.currentData.cover = img.data.content;
        this.showGallery = false;
      },
      modify() {
        /*bbn.fn.post(
              "action/delete",
              {
                id: this.currentData.id
              },  d => {
                if (d.success) {
                }
              });
            bbn.fn.post(
              "action/add",
              {
                url: this.currentData.url,
                description: this.currentData.description,
                title: this.currentData.title,
                id_parent:  this.idParent,
              },  d => {
                if (d.success) {
                  this.$refs.tree.reload();
                }
              });*/
        bbn.fn.post(this.root + "actions/bookmarks/modify", {
          url: this.currentData.url,
          description: this.currentData.description,
          title: this.currentData.title,
          id: this.currentData.id,
          cover: this.currentData.cover,
          screenshot_path: this.currentData.screenshot_path,
          id_screenshot: this.currentData.id_screenshot,
        },  d => {
          if (d.success) {
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
            }
          });
        return;
      },
    },
    mounted() {
      let sc = this.getRef("scroll");
    },
    watch: {
      'currentData.url'() {
        if (!this.currentData.id) {
          clearTimeout(this.checkTimeout);
          this.checkTimeout = setTimeout(() => {
            this.checkUrl();
          }, 250);
        }
      },
      currentNode(v) {
        if (v) {
          this.currentData = {
            url: v.data.url || "",
            title: v.data.text || "",
            description: v.data.description || "",
            id: v.data.id || "",
            cover: v.data.cover || null,
            id_screenshot: v.data.id_screenshot || "",
            screenshot_path: v.data.screenshot_path || "",
            clicked: v.data.clicked || 0
          };
        }
        else {
          this.resetForm();
        }
      },
    }
  };
})();