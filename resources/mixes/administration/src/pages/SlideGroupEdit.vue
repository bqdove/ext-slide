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
                action: `${window.api}/mall/admin/upload`,
                form: {
                    picture1: '',
                    picture2: '',
                    picture3: '',
                    picture4: '',
                },
            };
        },
        methods: {
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            removeSlide1() {
                this.form.picture1 = '';
            },
            removeSlide2() {
                this.form.picture1 = '';
            },
            removeSlide3() {
                this.form.picture1 = '';
            },
            removeSlide4() {
                this.form.picture1 = '';
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
            uploadBefore() {
                injection.loading.start();
            },
            uploadError(error, data) {
                const self = this;
                injection.loading.error();
                if (typeof data.message === 'object') {
                    for (const p in data.message) {
                        self.$notice.error({
                            title: data.message[p],
                        });
                    }
                } else {
                    self.$notice.error({
                        title: data.message,
                    });
                }
            },
            uploadFormatError(file) {
                this.$notice.warning({
                    title: '文件格式不正确',
                    desc: `文件 ${file.name} 格式不正确`,
                });
            },
            uploadSuccess(data) {
                const self = this;
                injection.loading.finish();
                self.$notice.open({
                    title: data.message,
                });
                self.form.picture1 = data.data.path;
            },
        },
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-group-edit">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>轮播图插件-编辑图片内容</span>
            </div>
            <card :bordered="false">
                <div class="prompt-box">
                    <p>关于</p>
                    <p>每编辑一张图片需要点击保存，所有相关设置完成，使用底部的"更新板块内容"前台展示页面才会变化</p>
                </div>
                <i-form ref="form" :model="form" :rules="ruleValidate" :label-width="200">
                    <row>
                        <i-col span="14">
                            <form-item label="上传图片" prop="picture">
                                <div>
                                    <div class="image-preview" v-if="form.picture1">
                                        <img :src="form.picture1">
                                        <icon type="ios-trash-outline" @click.native="removeSlide1"></icon>
                                        <div class="clearfix">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </div>
                                    <upload :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.picture1 === '' || form.picture1 === null">
                                        <div class="clearfix upload-picture">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </upload>
                                </div>
                                <div>
                                    <div class="image-preview" v-if="form.picture2">
                                        <img :src="form.picture2">
                                        <icon type="ios-trash-outline" @click.native="removeSlide2"></icon>
                                        <div class="clearfix">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </div>
                                    <upload :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.picture2 === '' || form.picture2 === null">
                                        <div class="clearfix upload-picture">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </upload>
                                </div>
                                <div>
                                    <div class="image-preview" v-if="form.picture3">
                                        <img :src="form.picture3">
                                        <icon type="ios-trash-outline" @click.native="removeSlide3"></icon>
                                        <div class="clearfix">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </div>
                                    <upload :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.picture3 === '' || form.picture3 === null">
                                        <div class="clearfix upload-picture">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </upload>
                                </div>
                                <div>
                                    <div class="image-preview" v-if="form.picture4">
                                        <img :src="form.picture4">
                                        <icon type="ios-trash-outline" @click.native="removeSlide4"></icon>
                                        <div class="clearfix">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </div>
                                    <upload :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.picture4 === '' || form.picture4 === null">
                                        <div class="clearfix upload-picture">
                                            <span>本地上传</span>
                                            <span>图片库上传</span>
                                        </div>
                                    </upload>
                                </div>
                            </form-item>
                        </i-col>
                    </row>
                    <!--<row>
                        <i-col span="14">
                            <form-item>
                                <i-button :loading="loading" type="primary"
                                          @click.native="submitSetGroup">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-col>
                    </row>-->
                </i-form>
            </card>
        </div>
    </div>
</template>