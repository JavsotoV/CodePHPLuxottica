/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.legal.gcacontrato.ctrMain',
        'gmo.legal.gcacontrato.crtMtto',
        'gmo.global.glbubigeo.ctrlstubigeo',
        'gmo.global.glbpersona.ctrlstglbpersona',
        'gmo.global.glbtienda.ctrlstglbtienda',
        'gmo.legal.gcaarrendador.ctrMtto',
        'gmo.legal.gcagarantia.ctrMtto',
        'gmo.legal.gcarenta.ctrMtto',
        'gmo.legal.gcabinary.ctrMtto',
        'gmo.legal.gcagasto.ctrMtto',
        'gmo.legal.gcaderecho.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.legal.gcacontrato.vpmain', {renderTo: Ext.getBody()});
    }

});
