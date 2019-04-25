// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.legal.gcaconsulta.ctrMain',
        'gmo.legal.gcaconsulta.ctrMtto',
        'gmo.legal.gcacontrato.ctrMain',
        'gmo.legal.gcacontrato.crtMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.legal.gcaconsulta.vpgcacontrato');
    }
});
