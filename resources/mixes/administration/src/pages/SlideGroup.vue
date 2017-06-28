<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('setting');
            });
        },
        data() {
            return {
                addGroupModal: false,
                deleteGroupModal: false,
                groupAdd: {
                    enabled: '',
                    id: '',
                    name: '',
                },
                groupDelete: {
                    id: '',
                },
                groupSet: {
                    enabled: '',
                    id: '',
                    name: '',
                },
                loading: false,
                self: this,
                slideColumns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'categoryName',
                        title: '组图名称',
                        width: 220,
                    },
                    {
                        align: 'center',
                        key: 'categoryId',
                        title: '组图ID',
                        width: 200,
                    },
                    {
                        key: 'enabled',
                        render() {
                            return `<i-switch size="large" v-model="row.status">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                    </i-switch>`;
                        },
                        title: '显示',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render() {
                            return `<dropdown>
                                    <i-button type="ghost">设置<icon type="arrow-down-b"></icon></i-button>
                                    <dropdown-menu slot="list">
                                    <dropdown-item @click.native="groupSetting">组图基础设置</dropdown-item>
                                    <dropdown-item name="goodSku" @click.native="editPicture">编辑图片内容</dropdown-item>
                                    </dropdown-menu></dropdown>
                                    <i-button @click.native="remove" class="delete-ad"
                                     type="ghost">删除</i-button>`;
                        },
                        title: '操作',
                        width: 180,
                    },
                ],
                slideData: [
                    {
                        categoryId: '3464',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                    {
                        categoryId: '4643',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                    {
                        categoryId: '4676',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                    {
                        categoryId: '1234',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                ],
                slideGroupModal: false,
            };
        },
        methods: {
            addGroup() {
                this.addGroupModal = true;
            },
            editPicture() {
                const self = this;
                self.$router.push({
                    path: 'group/edit',
                });
            },
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            groupSetting() {
                this.slideGroupModal = true;
            },
            remove() {
                this.deleteGroupModal = true;
            },
            submitAddGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupAdd.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
            submitDeleteGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupDelete.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
            submitSetGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupSet.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-group">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>轮播图插件-查看组图</span>
            </div>
            <card :bordered="false">
                <div class="slide-list">
                    <i-button type="ghost" @click.native="addGroup">+新增组图</i-button>
                    <i-button type="text" icon="android-sync" class="refresh">刷新</i-button>
                    <i-table class="slide-table"
                             :columns="slideColumns"
                             :context="self"
                             :data="slideData"
                             ref="slideList"
                             highlight-row>
                    </i-table>
                </div>
                <modal
                        v-model="slideGroupModal"
                        title="组图基础设置" class="upload-picture-modal">
                    <div>
                        <i-form ref="groupSet" :model="groupSet" :rules="ruleValidate" :label-width="100">
                            <row>
                                <i-col span="14">
                                    <form-item label="组图名称">
                                        <i-input v-model="groupSet.name"></i-input>
                                        <p class="tip">商城前台不显示，名称仅用于后台标记分类</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="组图ID">
                                        <i-input v-model="groupSet.id"></i-input>
                                        <p class="tip">可留空，系统会自动分配一个ID</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="是否显示">
                                        <radio-group v-model="groupSet.enabled">
                                            <radio label="是"></radio>
                                            <radio label="否"></radio>
                                        </radio-group>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item>
                                        <i-button :loading="loading" type="primary"
                                                  @click.native="submitSetGroup">
                                            <span v-if="!loading">确认提交</span>
                                            <span v-else>正在提交…</span>
                                        </i-button>
                                    </form-item>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
                <modal
                        v-model="addGroupModal"
                        title="新增组图" class="upload-picture-modal">
                    <div>
                        <i-form ref="groupAdd" :model="groupAdd" :rules="ruleValidate" :label-width="100">
                            <row>
                                <i-col span="14">
                                    <form-item label="组图名称">
                                        <i-input v-model="groupAdd.name"></i-input>
                                        <p class="tip">商城前台不显示，名称仅用于后台标记分类</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="组图ID">
                                        <i-input v-model="groupAdd.id"></i-input>
                                        <p class="tip">可留空，系统会自动分配一个ID</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="是否显示">
                                        <radio-group v-model="groupAdd.enabled">
                                            <radio label="是"></radio>
                                            <radio label="否"></radio>
                                        </radio-group>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item>
                                        <i-button :loading="loading" type="primary"
                                                  @click.native="submitEditCategory">
                                            <span v-if="!loading">确认提交</span>
                                            <span v-else>正在提交…</span>
                                        </i-button>
                                    </form-item>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
                <modal
                        v-model="addCategoryModal"
                        title="新增分类" class="upload-picture-modal">
                    <div class="slide-category-modal">
                        <i-form ref="groupAdd" :model="groupAdd" :rules="ruleValidate" :label-width="100">
                            <row>
                                <i-col span="14">
                                    <form-item label="组图名称">
                                        <i-input v-model="groupAdd.name"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="组图ID">
                                        <i-input v-model="groupAdd.id"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item>
                                        <i-button :loading="loading" type="primary"
                                                  @click.native="submitAddGroup">
                                            <span v-if="!loading">确认提交</span>
                                            <span v-else>正在提交…</span>
                                        </i-button>
                                    </form-item>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
                <modal
                        v-model="deleteGroupModal"
                        title="删除" class="upload-picture-modal">
                    <div class="slide-category-delete-modal">
                        <i-form ref="groupDelete" :model="groupDelete" :rules="ruleValidate">
                            <row>
                                <i-col>
                                    <p>删除后不可恢复，请输入组图ID：{{ groupDelete.id }} 以确认删除</p>
                                    <i-input v-model="groupDelete.id" style="width: 124px"></i-input>
                                </i-col>
                            </row>
                            <row>
                                <i-col>
                                    <i-button :loading="loading" type="primary"
                                              @click.native="submitDeleteGroup">
                                        <span v-if="!loading">确认提交</span>
                                        <span v-else>正在提交…</span>
                                    </i-button>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
            </card>
        </div>
    </div>
</template>