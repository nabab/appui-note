// Javascript Document

(()=> {
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
          path: "",
          id_screenshot: "",
          count: 0,
        },
        currentSource: [],
        drag: true,
      }
    },
    methods: {
      showScreenshot() {
        this.getData();
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
                  }
                })
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
          window.open(this.currentData.url, this.currentData.id);
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
      isDragEnd(event, nodeSrc, nodeDest) {
        if (nodeDest.data.url) {
          event.preventDefault();
        }
        else {
          bbn.fn.post(this.root + "actions/bookmarks/move", {
            source: nodeSrc.data.id,
            dest: nodeDest.data.id
          }, d => {
            bbn.fn.log(nodeSrc, nodeDest, "nodes");
          });
        }
        bbn.fn.log(event);
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
                    }
                  })
                }
                bbn.fn.log("d.data.images :", this.currentData.images);
              }
              return false;
            },
            e => {
              bbn.fn.log(e);
            }
          );
        }
      },
      selectTree(node) {
        this.currentNode = node;
        bbn.fn.log("node :", this.currentNode.data);
        if (this.currentNode.data.id) {
          this.$nextTick(() => {
            bbn.fn.log("ça marche", this.currentNode, this.currentNode.data.count);
            bbn.fn.post(
              this.root + "actions/bookmarks/count",
              {
                id: this.currentNode.data.id,
              },
              d => {
                bbn.fn.log("d", d);
                if (d.success) {
                  this.currentData.count = d.count;
                }
              }
            );
            bbn.fn.log("count + 1", this.currentData.count);
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
              this.currentData.path = d.data.path;
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
              bbn.fn.log(d);
              this.currentData.id = d.id_bit;
              this.currentData.count = 0;
              appui.success();
              this.getData();
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
                  bbn.fn.log("d = ", d);
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
          path: this.currentData.path,
          id_screenshot: this.currentData.id_screenshot,
        },  d => {
          if (d.success) {
            this.getData();
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
    },
    mounted() {
      this.getData();
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
          bbn.fn.log("v", v);
          this.currentData = {
            url: v.data.url || "",
            title: v.data.text || "",
            description: v.data.description || "",
            id: v.data.id || "",
            cover: v.data.cover || null,
            id_screenshot: v.data.id_screenshot || "",
            path: v.data.path || "",
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