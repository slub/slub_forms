#!/bin/sh

mysqldump -u typo3 -px735q.cR -h sdvmysql8.slub-dresden.de typo3 tx_slubforms_domain_model_fieldsets tx_slubforms_forms_fieldsets_mm tx_slubforms_domain_model_fields tx_slubforms_domain_model_email tx_slubforms_fieldsets_fields_mm tx_slubforms_domain_model_forms > data/tx_slub_forms.sql

# import to own db:
DEVPASSWD="pwxoS4mkkt"

mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 -e 'TRUNCATE tx_slubforms_domain_model_fieldsets'
mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 -e 'TRUNCATE tx_slubforms_forms_fieldsets_mm'
mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 -e 'TRUNCATE tx_slubforms_domain_model_fields'
mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 -e 'TRUNCATE tx_slubforms_domain_model_email'
mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 -e 'TRUNCATE tx_slubforms_fieldsets_fields_mm'
mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 -e 'TRUNCATE tx_slubforms_domain_model_forms'

mysql -ubigga -p$DEVPASSWD -h localhost -D typo3 < data/tx_slub_forms.sql

#mysql -ubigga -ppwxoS4mkkt -h localhost -D typo3 -e 'TRUNCATE tx_dlf_documents'
#mysql -ubigga -ppwxoS4mkkt -h localhost -D typo3 < data/tx_dlf_documents.sql
