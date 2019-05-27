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
        'gmo.global.glbubigeo.ctrlstubigeo',
        'gmo.global.glbpersona.ctrMain',
        'gmo.global.glbpersona.ctrMtto',
        'gmo.global.utiles.ctrfuncion',
        'gmo.global.glbpersonadomicilio.ctrMtto',
        'gmo.global.glbrepresentante.ctrMtto',
        'gmo.global.glbpersona.ctrlstglbpersona'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.global.glbpersona.vpmain', {renderTo: Ext.getBody()});
    }

});
