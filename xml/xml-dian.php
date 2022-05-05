<?php

	$xml = new DomDocument("1.0", "UTF-8");
	$xml-> xmlStandalone = false;
	$xml -> formatOutput = true;
	/*create element using createElement();
	append child to parent using appendChild();*/

	$numerofactura = 1;
	$ProviderID = 700085380;  //NIT de la empresa
	$SoftwareID = "fc7bab96-4a9c-4443-98fc-447ecd1a53b6"; //numero asignado por la DIAN
	$SoftwareSecurityCode = "54bf6b1cfe683bcaf1fe8b67e98e9facfb5d3ec011a9966327f6d2b5c368d59d76d811e40d19f050e4a8ea0eaa0a0d42"; //la clave mencionada se asigna a cada rango de facturación autorizado es un número de 96 caracteres hexadecimales

	$Invoice = $xml -> createElement("fe:Invoice");
	$Invoice -> setAttribute("xmlns:fe","http://www.dian.gov.co/contratos/facturaelectronica/v1");
	$Invoice -> setAttribute("xmlns:cac","urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
	$Invoice -> setAttribute("xmlns:cbc", "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
	$Invoice -> setAttribute("xmlns:clm54217", "urn:un:unece:uncefact:codelist:specification:54217:2001");
	$Invoice -> setAttribute("xmlns:clm66411", "urn:un:unece:uncefact:codelist:specification:66411:2001");
	$Invoice -> setAttribute("xmlns:clmIANAMIMEMediaType", "urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003");
	$Invoice -> setAttribute("xmlns:qdt", "urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2");
	$Invoice -> setAttribute("xmlns:sts", "http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures");
	$Invoice -> setAttribute("xmlns:udt", "urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
	$Invoice -> setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
	$Invoice -> setAttribute("xsi:schemaLocation", "http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL_v1_0_fos.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd");
	
	$xml -> appendChild($Invoice);
		//parent -> appendChild(child)

	$UBLExtensions =$xml -> createElement("ext:UBLExtensions");
	$Invoice -> appendChild($UBLExtensions);

		$UBLExtensions1 =$xml -> createElement("ext:UBLExtension");
		$UBLExtensions -> appendChild($UBLExtensions1);

			$extExtensionContent =$xml -> createElement("ext:ExtensionContent");
			$UBLExtensions1 -> appendChild($extExtensionContent);

				$stsDianExtensions =$xml -> createElement("sts:DianExtensions");
				$extExtensionContent -> appendChild($stsDianExtensions);

					$stsInvoiceControl =$xml -> createElement("sts:InvoiceControl");
					$stsDianExtensions -> appendChild($stsInvoiceControl);

						$stsInvoiceAuthorization =$xml -> createElement("sts:InvoiceAuthorization", "000001");
						$stsInvoiceControl -> appendChild($stsInvoiceAuthorization);

						$stsAuthorizationPeriod =$xml -> createElement("sts:AuthorizationPeriod");
						$stsInvoiceControl -> appendChild($stsAuthorizationPeriod);

							$cbcStartDate =$xml -> createElement("cbc:StartDate", date("Y/m/d"));
							$stsAuthorizationPeriod -> appendChild($cbcStartDate);

							$finfecha =  date("Y/m/d");
							$nuevafecha = strtotime ( '+2 year' , strtotime ( $finfecha ) );

							$cbcEndDate =$xml -> createElement("cbc:EndDate", date ( "Y/m/d",$nuevafecha));
							$stsAuthorizationPeriod -> appendChild($cbcEndDate);

						$stsAuthorizedInvoices =$xml -> createElement("sts:AuthorizedInvoices");
						$stsInvoiceControl -> appendChild($stsAuthorizedInvoices);

							$stsPrefix =$xml -> createElement("sts:Prefix", "0");
							$stsAuthorizedInvoices -> appendChild($stsPrefix);

							$stsFrom =$xml -> createElement("sts:From", $numerofactura);
							$stsAuthorizedInvoices -> appendChild($stsFrom);

							$stsTo =$xml -> createElement("sts:To", "19999999");
							$stsAuthorizedInvoices -> appendChild($stsTo);

					$stsInvoiceSource =$xml -> createElement("sts:InvoiceSource");
					$stsDianExtensions -> appendChild($stsInvoiceSource);

						$cbcIdentificationCode =$xml -> createElement("cbc:IdentificationCode", "CO");
						$cbcIdentificationCode -> setAttribute("listAgencyID", "6");
						$cbcIdentificationCode -> setAttribute("listAgencyName", "United Nations Economic Commission for Europe");
						$cbcIdentificationCode -> setAttribute("listSchemeURI", "urn:oasis:names:specification:ubl:codelist:gc:CountryIdentificationCode-2.0");
						$stsInvoiceSource -> appendChild($cbcIdentificationCode);

					$stsSoftwareProvider =$xml -> createElement("sts:SoftwareProvider");
					$stsDianExtensions -> appendChild($stsSoftwareProvider);

						$stsProviderID =$xml -> createElement("sts:ProviderID", $ProviderID);
						$stsProviderID -> setAttribute("schemeAgencyID", "195");
						$stsProviderID -> setAttribute("schemeAgencyName", "CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
						$stsProviderID -> setAttribute("schemeName", "SoftwareMakerID");
						$stsProviderID -> setAttribute("schemeURI", "http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#SoftwareMakerID");
						$stsSoftwareProvider -> appendChild($stsProviderID);

						$stsSoftwareID =$xml -> createElement("sts:SoftwareID", $SoftwareID);
						$stsSoftwareID -> setAttribute("schemeAgencyID", "195");
						$stsSoftwareID -> setAttribute("schemeAgencyName", "CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
						$stsSoftwareID -> setAttribute("schemeName", "SoftwareID");
						$stsSoftwareID -> setAttribute("schemeURI", "http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#sofwareID");
						$stsSoftwareProvider -> appendChild($stsSoftwareID);

					$stsSoftwareSecurityCode =$xml -> createElement("sts:SoftwareSecurityCode", $SoftwareSecurityCode);
					$stsSoftwareSecurityCode -> setAttribute("schemeAgencyID","195");
					$stsSoftwareSecurityCode -> setAttribute("schemeAgencyName", "CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
					$stsSoftwareSecurityCode -> setAttribute("schemeName", "SoftwareSecurityCode");
					$stsSoftwareSecurityCode -> setAttribute("schemeURI", "http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#SofwareSecurityCode");
					$stsDianExtensions -> appendChild($stsSoftwareSecurityCode);


		$UBLExtensions2 =$xml -> createElement("ext:UBLExtension");
		$UBLExtensions -> appendChild($UBLExtensions2);

			$extExtensionContent2 =$xml -> createElement("ext:ExtensionContent");
			$UBLExtensions2 -> appendChild($extExtensionContent2);

				$dsSignature =$xml -> createElement("ds:Signature");
				$dsSignature -> setAttribute("xmlns:ds", "http://www.w3.org/2000/09/xmldsig#");
				$dsSignature -> setAttribute("Id", "xmldsig-e2f27048-53c6-4130-bf5e-5915089e9807");
				$extExtensionContent2 -> appendChild($dsSignature);

					$dsSignedInfo =$xml -> createElement("ds:SignedInfo");
					$dsSignature -> appendChild($dsSignedInfo);

						$dsCanonicalizationMethod =$xml -> createElement("ds:CanonicalizationMethod");
						$dsCanonicalizationMethod -> setAttribute("Algorithm","http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
						$dsSignedInfo -> appendChild($dsCanonicalizationMethod);

						$dsSignatureMethod =$xml -> createElement("ds:SignatureMethod");
						$dsSignatureMethod -> setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#rsa-sha-1");
						$dsSignedInfo -> appendChild($dsSignatureMethod);

						$dsReference =$xml -> createElement("ds:Reference");
						$dsReference -> setAttribute("Id", "xmldsig-e2f27048-53c6-4130-bf5e-5915089e9807-ref0");
						$dsReference -> setAttribute("URI", "");
						$dsSignedInfo -> appendChild($dsReference);

							$dsTransforms =$xml -> createElement("ds:Transforms");
							$dsReference -> appendChild($dsTransforms);

								$dsTransform1 =$xml -> createElement("ds:Transform");
								$dsTransform1 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#enveloped-signature");
								$dsTransforms -> appendChild($dsTransform1);

							$dsDigestMethod =$xml -> createElement("ds:DigestMethod");
							$dsDigestMethod -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
							$dsReference -> appendChild($dsDigestMethod);

							$dsDigestValue =$xml -> createElement("ds:DigestValue", "nQoslfKNH9/a7YoLBXFYsyTkBJ8=");
							$dsReference -> appendChild($dsDigestValue);

						$dsReference2 =$xml -> createElement("ds:Reference");
						$dsReference2 -> setAttribute("URI", "#xmldsig-87d128b5-aa31-4f0b-8e45-3d9cfa0eec26-keyinfo");
						$dsSignedInfo -> appendChild($dsReference2);

							$dsDigestMethod2 =$xml -> createElement("ds:DigestMethod");
							$dsDigestMethod2 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
							$dsReference2 -> appendChild($dsDigestMethod2);

							$dsDigestValue2 =$xml -> createElement("ds:DigestValue", "0iE/FGZgLfbnV9DhUaDBBVPjn44=");
							$dsReference2 -> appendChild($dsDigestValue2);

						$dsReference3 =$xml -> createElement("ds:Reference");
						$dsReference3 -> setAttribute("Type","http://uri.etsi.org/01903#SignedProperties");
						$dsReference3 -> setAttribute("URI", "#xmldsig-e2f27048-53c6-4130-bf5e-5915089e9807-signedprops");
						$dsSignedInfo -> appendChild($dsReference3);

							$dsDigestMethod3 =$xml -> createElement("ds:DigestMethod");
							$dsDigestMethod3 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
							$dsReference3 -> appendChild($dsDigestMethod3);

							$dsDigestValue3 =$xml -> createElement("ds:DigestValue", "4VZaJAZGvxifoGYetOYuOEuZUrE=");
							$dsReference3 -> appendChild($dsDigestValue3);


					$dsSignatureValue =$xml -> createElement("ds:SignatureValue", "Ijd7mzeBj4NV/F+EyP7WQO13Bi1wLNFFyvQPmiXgcTQ9zBYtuTWNeUS+vk425vrA1ghgC8Vfpem9 ODzhe/gsV5R82Ya9Dp3Ek6SDIoJYsD1nFEaq5h1Gt56iMr+hPEvyvR6ddQl+n4sRhmLCKvKV3Jge L8MvAx6Bg+m8Z7sQVdbBjLE/4oSdN+jo8DpUQrPuKMg0ZRmMEBp4LGbljQE0esFLG0cHmlLeFEZH");
					$dsSignatureValue -> setAttribute("Id", "xmldsig-e2f27048-53c6-4130-bf5e-5915089e9807-sigvalue");
					$dsSignature -> appendChild($dsSignatureValue);

					$dsKeyInfo =$xml -> createElement("ds:KeyInfo");
					$dsKeyInfo -> setAttribute("Id", "xmldsig-87d128b5-aa31-4f0b-8e45-3d9cfa0eec26-keyinfo");
					$dsSignature -> appendChild($dsKeyInfo);

						$dsX509Data =$xml -> createElement("ds:X509Data");
						$dsKeyInfo -> appendChild($dsX509Data);

							$dsX509Certificate =$xml -> createElement("ds:X509Certificate", "MIIILDCCBhSgAwIBAgIIfq9P6xyRMBEwDQYJKoZIhvcNAQELBQAwgbQxIzAhBgkqhkiG9w0BCQEW FGluZm9AYW5kZXNzY2QuY29tLmNvMSMwIQYDVQQDExpDQSBBTkRFUyBTQ0QgUy5BLiBDbGFzZSBJ STEwMC4GA1UECxMnRGl2aXNpb24gZGUgY2VydGlmaWNhY2lvbiBlbnRpZGFkIGZpbmFsMRMwEQYD");
							$dsX509Data -> appendChild($dsX509Certificate);

					$dsObject =$xml -> createElement("ds:Object");
					$dsSignature -> appendChild($dsObject);

						$xadesQualifyingProperties =$xml -> createElement("xades:QualifyingProperties");
						$xadesQualifyingProperties -> setAttribute("xmlns:xades", "http://uri.etsi.org/01903/v1.3.2#");
						$xadesQualifyingProperties -> setAttribute("xmlns:xades141", "http://uri.etsi.org/01903/v1.4.1#");
						$xadesQualifyingProperties -> setAttribute("Target", "#xmldsig-e2f27048-53c6-4130-bf5e-5915089e9807");
						$dsObject -> appendChild($xadesQualifyingProperties);

							$xadesSignedProperties =$xml -> createElement("xades:SignedProperties");
							$xadesSignedProperties -> setAttribute("Id", "xmldsig-e2f27048-53c6-4130-bf5e-5915089e9807-signedprops");
							$xadesQualifyingProperties -> appendChild($xadesSignedProperties);

								$xadesSignedSignatureProperties =$xml -> createElement("xades:SignedSignatureProperties");
								$xadesSignedProperties -> appendChild($xadesSignedSignatureProperties);

									$xadesSigningTime =$xml -> createElement("xades:SigningTime", date("y/m/d - h:m:s"));
									$xadesSignedSignatureProperties -> appendChild($xadesSigningTime);

									$xadesSigningCertificate =$xml -> createElement("xades:SigningCertificate");
									$xadesSignedSignatureProperties -> appendChild($xadesSigningCertificate);

										$xadesCert =$xml -> createElement("xades:Cert");
										$xadesSigningCertificate -> appendChild($xadesCert);

											$xadesCertDigest =$xml -> createElement("xades:CertDigest");
											$xadesCert -> appendChild($xadesCertDigest);

												$dsDigestMethod1 =$xml -> createElement("ds:DigestMethod");
												$dsDigestMethod1 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
												$xadesCertDigest -> appendChild($dsDigestMethod1);

												$dsDigestValue4 =$xml -> createElement("ds:DigestValue", "2el6MfWvYsvEaa/TV513a7tVK0g=");
												$xadesCertDigest -> appendChild($dsDigestValue4);

											$xadesIssuerSerial =$xml -> createElement("xades:IssuerSerial");
											$xadesCert -> appendChild($xadesIssuerSerial);

												$dsX509IssuerName =$xml -> createElement("ds:X509IssuerName", "C=CO,L=Bogota D.C.,O=Andes SCD.,OU=Division de certificacion entidad final,CN=Ficticious ECD Colombia Clase II,1.2.840.113549.1.9.1=#1614696e666f40616e6465737363642e636f6d2e636f");
												$xadesIssuerSerial -> appendChild($dsX509IssuerName);

												$dsX509SerialNumber2 =$xml -> createElement("ds:X509SerialNumber", "9128602840918470673");
												$xadesIssuerSerial -> appendChild($dsX509SerialNumber2);

										$xadesCert2 =$xml -> createElement("xades:Cert");
										$xadesSigningCertificate -> appendChild($xadesCert2);

											$xadesCertDigest2 =$xml -> createElement("xades:CertDigest");
											$xadesCert2 -> appendChild($xadesCertDigest2);

												$dsDigestMethod2 =$xml -> createElement("ds:DigestMethod");
												$dsDigestMethod2 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
												$xadesCertDigest2 -> appendChild($dsDigestMethod2);

												$dsDigestValue4 =$xml -> createElement("ds:DigestValue", "YGJTXnOzmebG2Mc6A/QapNi1PRA=");
												$xadesCertDigest2 -> appendChild($dsDigestValue4);

											$xadesIssuerSerial =$xml -> createElement("xades:IssuerSerial");
											$xadesCert2 -> appendChild($xadesIssuerSerial);

												$dsX509IssuerName =$xml -> createElement("ds:X509IssuerName", "C=CO,L=Bogota D.C.,O=Andes SCD,OU=Division de certificacion,CN=Sub CA Ficticious ECD Colombia S.A.,1.2.840.113549.1.9.1=#1614696e666f40616e6465737363642e636f6d2e636f");
												$xadesIssuerSerial -> appendChild($dsX509IssuerName);

												$dsX509SerialNumber =$xml -> createElement("ds:X509SerialNumber", "7958418607150926283");
												$xadesIssuerSerial -> appendChild($dsX509SerialNumber);

										$xadesCert3 =$xml -> createElement("xades:Cert");
										$xadesSigningCertificate -> appendChild($xadesCert3);

											$xadesCertDigest3 =$xml -> createElement("xades:CertDigest");
											$xadesCert3 -> appendChild($xadesCertDigest3);

												$dsDigestMethod3 =$xml -> createElement("ds:DigestMethod");
												$dsDigestMethod3 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
												$xadesCertDigest3 -> appendChild($dsDigestMethod3);

												$dsDigestValue6 =$xml -> createElement("ds:DigestValue", "Ohixl6upD6av8N7pEvDABhEL6hM=");
												$xadesCertDigest3 -> appendChild($dsDigestValue6);

											$xadesIssuerSerial =$xml -> createElement("xades:IssuerSerial");
											$xadesCert3 -> appendChild($xadesIssuerSerial);

												$dsX509IssuerName2 =$xml -> createElement("ds:X509IssuerName", "C=CO,L=Bogota D.C.,O=Andes SCD,OU=Division de certificacion,CN=ROOT CA Ficticious ECD Colombia S.A.,1.2.840.113549.1.9.1=#1614696e666f40616e6465737363642e636f6d2e636f");
												$xadesIssuerSerial -> appendChild($dsX509IssuerName2);

												$dsX509SerialNumber2 =$xml -> createElement("ds:X509SerialNumber", "3248112716520923666");
												$xadesIssuerSerial -> appendChild($dsX509SerialNumber2);

									$xadesSignaturePolicyIdentifier =$xml -> createElement("xades:SignaturePolicyIdentifier");
									$xadesSignedSignatureProperties -> appendChild($xadesSignaturePolicyIdentifier);

										$xadesSignaturePolicyId =$xml -> createElement("xades:SignaturePolicyId");
										$xadesSignaturePolicyIdentifier -> appendChild($xadesSignaturePolicyId);

											$xadesSigPolicyId =$xml -> createElement("xades:SigPolicyId");
											$xadesSignaturePolicyId -> appendChild($xadesSigPolicyId);

												$xadesIdentifier =$xml -> createElement("xades:Identifier", "http://www.facturae.es/politica_de_firma_formato_facturae/politica_de_firma_formato_facturae_v3_1.pdf");
												$xadesSigPolicyId -> appendChild($xadesIdentifier);

											$xadesSigPolicyHash =$xml -> createElement("xades:SigPolicyHash");
											$xadesSignaturePolicyId -> appendChild($xadesSigPolicyHash);

												$dsDigestMethod4 =$xml -> createElement("ds:DigestMethod");
												$dsDigestMethod4 -> setAttribute("Algorithm", "http://www.w3.org/2000/09/xmldsig#sha-1");
												$xadesSigPolicyHash -> appendChild($dsDigestMethod4);

												$dsDigestValue7 =$xml -> createElement("ds:DigestValue", "Ohixl6upD6av8N7pEvDABhEL6hM=");
												$xadesSigPolicyHash -> appendChild($dsDigestValue7);


									$xadesSignerRole =$xml -> createElement("xades:SignerRole");
									$xadesSignedSignatureProperties -> appendChild($xadesSignerRole);

										$xadesClaimedRoles =$xml -> createElement("xades:ClaimedRoles");
										$xadesSignerRole -> appendChild($xadesClaimedRoles);

											$xadesClaimedRole =$xml -> createElement("xades:ClaimedRole", "supplier");
											$xadesClaimedRoles -> appendChild($xadesClaimedRole);


	$UBLVersionID =$xml -> createElement("cbc:UBLVersionID", "UBL 2.0");
	$Invoice -> appendChild($UBLVersionID);

	$CustomizationID =$xml -> createElement("cbc:CustomizationID", "DIAN_UBL_v1_0_foc.xsd");
	$CustomizationID -> setAttribute("schemeName", "nombre archivo xsd");
	$CustomizationID -> setAttribute("schemeURI", "http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#xsdFile");
	$Invoice -> appendChild($CustomizationID);

	$ProfileID =$xml -> createElement("cbc:ProfileID", "Factura de Venta Contingencia - Transcripción");
	$ProfileID -> setAttribute("schemeName", "Lista de perfiles UBL de la DIAN");
	$ProfileID -> setAttribute("schemeURI", "http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#profileList");
	$Invoice -> appendChild($ProfileID);
	
	$cbcID =$xml -> createElement("cbc:ID", "8110007869");
	$Invoice -> appendChild($cbcID);

	$cbcUUID =$xml -> createElement("cbc:UUID", "a1beaaef31a0c05e97b0c4f6fbc1902d66a93245");
	$cbcUUID -> setAttribute("schemeAgencyID", "195");
	$cbcUUID -> setAttribute("schemeAgencyName", "CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
	$Invoice -> appendChild($cbcUUID);

	$cbcIssueDate =$xml -> createElement("cbc:IssueDate", "2015-07-21");
	$Invoice -> appendChild($cbcIssueDate);

	$cbcIssueTime =$xml -> createElement("cbc:IssueTime", "00:00:00");
	$Invoice -> appendChild($cbcIssueTime);

	$cbcInvoiceTypeCode =$xml -> createElement("cbc:InvoiceTypeCode", "2");
	$cbcInvoiceTypeCode -> setAttribute("listAgencyID", "195");
	$cbcInvoiceTypeCode -> setAttribute("listAgencyName", "CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
	$cbcInvoiceTypeCode -> setAttribute("listName", "Lista de códigos por tipo de factura");
	$cbcInvoiceTypeCode -> setAttribute("listURI", "http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#InvoiceTypeCodeList");
	$Invoice -> appendChild($cbcInvoiceTypeCode);

	$cbcNote =$xml -> createElement("cbc:Note", "Set de pruebas = fos0001_900373076");
	$Invoice -> appendChild($cbcNote);

	$cbcDocumentCurrencyCode =$xml -> createElement("cbc:DocumentCurrencyCode", "COP");
	$Invoice -> appendChild($cbcDocumentCurrencyCode);

	$feAccountingSupplierParty =$xml -> createElement("fe:AccountingSupplierParty");
	$Invoice -> appendChild($feAccountingSupplierParty);

		$cbcAdditionalAccountID =$xml -> createElement("cbc:AdditionalAccountID", "1");
		$feAccountingSupplierParty -> appendChild($cbcAdditionalAccountID);

		$feParty =$xml -> createElement("fe:Party");
		$feAccountingSupplierParty -> appendChild($feParty);

			$cacPartyIdentification =$xml -> createElement("cac:PartyIdentification");
			$feParty -> appendChild($cacPartyIdentification);

				$cbcID2 =$xml -> createElement("cbc:ID", "900373076");
				$cbcID2 -> setAttribute("schemeAgencyID", "195");
				$cbcID2 -> setAttribute("schemeAgencyName","CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
				$cbcID2 -> setAttribute("schemeID", "31");
				$cbcID2 -> setAttribute("schemeName", "NIT del contribuyente");
				$cacPartyIdentification -> appendChild($cbcID2);

			$cacPartyName =$xml -> createElement("cac:PartyName");
			$feParty -> appendChild($cacPartyName);

				$cbcName =$xml -> createElement("cbc:Name", "PJ - 900373076 - Adquiriente FE");
				$cacPartyName -> appendChild($cbcName);

			$fePhysicalLocation =$xml -> createElement("fe:PhysicalLocation");
			$feParty -> appendChild($fePhysicalLocation);

				$feAddress =$xml -> createElement("fe:Address");
				$fePhysicalLocation -> appendChild($feAddress);

					$cbcCitySubdivisionName =$xml -> createElement("cbc:CitySubdivisionName", "Centro");
					$feAddress -> appendChild($cbcCitySubdivisionName);

					$cbcCityName =$xml -> createElement("cbc:CityName", "Velez");
					$feAddress -> appendChild($cbcCityName);

					$cbcCountrySubentity =$xml -> createElement("cbc:CountrySubentity", "Santander");
					$feAddress -> appendChild($cbcCountrySubentity);

					$cacAddressLine =$xml -> createElement("cac:AddressLine");
					$feAddress -> appendChild($cacAddressLine);

						$cbcLine =$xml -> createElement("cbc:Line", "carrera 8 Nº 6C - 89");
						$cacAddressLine -> appendChild($cbcLine);

					$cacCountry =$xml -> createElement("cac:Country");
					$feAddress -> appendChild($cacCountry);

						$cbcIdentificationCode =$xml -> createElement("cbc:IdentificationCode", "CO");
						$cacCountry -> appendChild($cbcIdentificationCode);


			$fePartyTaxScheme =$xml -> createElement("fe:PartyTaxScheme");
			$feParty -> appendChild($fePartyTaxScheme);

				$cbcTaxLevelCode =$xml -> createElement("cbc:TaxLevelCode", "2");
				$cbcTaxLevelCode -> setAttribute("listName", "Régimen Común de IVA");
				$fePartyTaxScheme -> appendChild($cbcTaxLevelCode);

				$cacTaxScheme =$xml -> createElement("cac:TaxScheme");
				$fePartyTaxScheme -> appendChild($cacTaxScheme);

			$fePartyLegalEntity =$xml -> createElement("fe:PartyLegalEntity");
			$feParty -> appendChild($fePartyLegalEntity);

				$cbcRegistrationName =$xml -> createElement("cbc:RegistrationName", "PJ - 900373076");
				$fePartyLegalEntity -> appendChild($cbcRegistrationName);

	$feAccountingCustomerParty =$xml -> createElement("fe:AccountingCustomerParty");
	$Invoice -> appendChild($feAccountingCustomerParty);

		$cbcAdditionalAccountID =$xml -> createElement("cbc:AdditionalAccountID", "2");
		$feAccountingCustomerParty -> appendChild($cbcAdditionalAccountID);	

		$feParty2 =$xml -> createElement("fe:Party");
		$feAccountingCustomerParty -> appendChild($feParty2);

			$cacPartyIdentification =$xml -> createElement("cac:PartyIdentification");
			$feParty2 -> appendChild($cacPartyIdentification);

				$cbcID3 =$xml -> createElement("cbc:ID", "8355990");
				$cbcID3 -> setAttribute("schemeAgencyID", "195");
				$cbcID3 -> setAttribute("schemeAgencyName", "CO, DIAN (Dirección de Impuestos y Aduanas Nacionales)");
				$cbcID3 -> setAttribute("schemeID", "22");
				$cbcID3 -> setAttribute("schemeURI","http://www.dian.gov.co/contratos/facturaelectronica/v1/anexo_v1_0.html#tipoDocIdentidad" );
				$cbcID3 -> setAttribute("schemeName", "Número del Documento de Identidad del Adquiriente; código del tipo en el atributo schemeID");
				$cacPartyIdentification -> appendChild($cbcID3);	

			$fePhysicalLocation =$xml -> createElement("fe:PhysicalLocation");
			$feParty2 -> appendChild($fePhysicalLocation);	

				$feAddress2 =$xml -> createElement("fe:Address");
				$fePhysicalLocation -> appendChild($feAddress2);

					$cbcDepartment =$xml -> createElement("cbc:Department", "Tolima");
					$feAddress2 -> appendChild($cbcDepartment);

					$cbcCitySubdivisionName =$xml -> createElement("cbc:CitySubdivisionName", "Centro");
					$feAddress2 -> appendChild($cbcCitySubdivisionName);

					$cbcCityName =$xml -> createElement("cbc:CityName", "Guamo");
					$feAddress2 -> appendChild($cbcCityName);

					$cbcCountrySubentity =$xml -> createElement("cbc:CountrySubentity", "Tolima");
					$feAddress2 -> appendChild($cbcCountrySubentity);

					$cacAddressLine =$xml -> createElement("cac:AddressLine");
					$feAddress2 -> appendChild($cacAddressLine);

						$cbcLine =$xml -> createElement("cbc:Line", "carrera 8 Nº 6C - 39");
						$cacAddressLine -> appendChild($cbcLine);

					$cacCountry =$xml -> createElement("cac:Country");
					$feAddress2 -> appendChild($cacCountry);

						$cbcIdentificationCode =$xml -> createElement("cbc:IdentificationCode", "CO");
						$cacCountry -> appendChild($cbcIdentificationCode);

			$fePartyTaxScheme2 =$xml -> createElement("fe:PartyTaxScheme");
			$feParty2 -> appendChild($fePartyTaxScheme2);	

				$cbcTaxLevelCode2 =$xml -> createElement("cbc:TaxLevelCode", "0");
				$fePartyTaxScheme2 -> appendChild($cbcTaxLevelCode2);

				$cacTaxScheme2 =$xml -> createElement("cac:TaxScheme");
				$fePartyTaxScheme2 -> appendChild($cacTaxScheme2);

			$fePerson =$xml -> createElement("fe:Person");
			$feParty2 -> appendChild($fePerson);

				$cbcFirstName =$xml -> createElement("cbc:FirstName", "Primer-N");
				$fePerson -> appendChild($cbcFirstName);

				$cbcFamilyName =$xml -> createElement("cbc:FamilyName", "Apellido-8355990");
				$fePerson -> appendChild($cbcFamilyName);

				$cbcMiddleName =$xml -> createElement("cbc:MiddleName", "Segundo-N");
				$fePerson -> appendChild($cbcMiddleName);

	$feTaxTotal =$xml -> createElement("fe:TaxTotal");
	$Invoice -> appendChild($feTaxTotal);

		$cbcTaxAmount =$xml -> createElement("cbc:TaxAmount", "1619504.64");
		$cbcTaxAmount -> setAttribute("currencyID", "COP");
		$feTaxTotal -> appendChild($cbcTaxAmount);

		$cbcTaxEvidenceIndicator =$xml -> createElement("cbc:TaxEvidenceIndicator", "false");
		$feTaxTotal -> appendChild($cbcTaxEvidenceIndicator);

		$feTaxSubtotal1 =$xml -> createElement("fe:TaxSubtotal");
		$feTaxTotal -> appendChild($feTaxSubtotal1);

			$cbcTaxableAmount  =$xml -> createElement("cbc:TaxableAmount", "10121904");
			$cbcTaxableAmount -> setAttribute("currencyID", "COP");
			$feTaxSubtotal1 -> appendChild($cbcTaxableAmount);

			$cbcTaxAmount2  =$xml -> createElement("cbc:TaxAmount", "419046.82");
			$cbcTaxAmount2 -> setAttribute("currencyID", "COP");
			$feTaxSubtotal1 -> appendChild($cbcTaxAmount2);

			$cbcPercent1  =$xml -> createElement("cbc:Percent", "16");
			$feTaxSubtotal1 -> appendChild($cbcPercent1);

			$cacTaxCategory1  =$xml -> createElement("cac:TaxCategory");
			$feTaxSubtotal1 -> appendChild($cacTaxCategory1);

				$cacTaxScheme1  =$xml -> createElement("cac:TaxScheme");
				$cacTaxCategory1 -> appendChild($cacTaxScheme1);

					$cbcID4  =$xml -> createElement("cbc:ID", "01");
					$cacTaxScheme1 -> appendChild($cbcID4);

	$feTaxTotal2 =$xml -> createElement("fe:TaxTotal");
	$Invoice -> appendChild($feTaxTotal2);

		$cbcTaxAmount2 =$xml -> createElement("cbc:TaxAmount", "419046.82");
		$cbcTaxAmount2 -> setAttribute("currencyID", "COP");
		$feTaxTotal2 -> appendChild($cbcTaxAmount2);

		$cbcTaxEvidenceIndicator2 =$xml -> createElement("cbc:TaxEvidenceIndicator", "false");
		$feTaxTotal2 -> appendChild($cbcTaxEvidenceIndicator2);

		$feTaxSubtotal2 =$xml -> createElement("fe:TaxSubtotal");
		$feTaxTotal2 -> appendChild($feTaxSubtotal2);

			$cbcTaxableAmount2  =$xml -> createElement("cbc:TaxableAmount", "10121904");
			$cbcTaxableAmount2 -> setAttribute("currencyID", "COP");
			$feTaxSubtotal2 -> appendChild($cbcTaxableAmount2);

			$cbcTaxAmount2  =$xml -> createElement("cbc:TaxAmount", "419046.82");
			$cbcTaxAmount2 -> setAttribute("currencyID", "COP");
			$feTaxSubtotal2 -> appendChild($cbcTaxAmount2);

			$cbcPercent2  =$xml -> createElement("cbc:Percent", "4.14");
			$feTaxSubtotal2 -> appendChild($cbcPercent2);

			$cacTaxCategory2  =$xml -> createElement("cac:TaxCategory");
			$feTaxSubtotal2 -> appendChild($cacTaxCategory2);

				$cacTaxScheme3  =$xml -> createElement("cac:TaxScheme");
				$cacTaxCategory2 -> appendChild($cacTaxScheme3);

					$cbcID5 =$xml -> createElement("cbc:ID", "03");
					$cacTaxScheme3 -> appendChild($cbcID5);

	$feLegalMonetaryTotal =$xml -> createElement("fe:LegalMonetaryTotal");
	$Invoice -> appendChild($feLegalMonetaryTotal);

		$cbcLineExtensionAmount =$xml -> createElement("cbc:LineExtensionAmount", "10121904");
		$cbcLineExtensionAmount -> setAttribute("currencyID", "COP");
		$feLegalMonetaryTotal -> appendChild($cbcLineExtensionAmount);

		$cbcTaxExclusiveAmount =$xml -> createElement("cbc:TaxExclusiveAmount", "2038551.46");
		$cbcTaxExclusiveAmount -> setAttribute("currencyID", "COP");
		$feLegalMonetaryTotal -> appendChild($cbcTaxExclusiveAmount);

		$cbcPayableAmount  =$xml -> createElement("cbc:PayableAmount", "12160455.46");
		$cbcPayableAmount -> setAttribute("currencyID", "COP");
		$feLegalMonetaryTotal -> appendChild($cbcPayableAmount);

	$feInvoiceLine =$xml -> createElement("fe:InvoiceLine");
	$Invoice -> appendChild($feInvoiceLine);

		$cbcID6 =$xml -> createElement("cbc:ID", "1");
		$feInvoiceLine -> appendChild($cbcID6);

		$cbcInvoicedQuantity =$xml -> createElement("cbc:InvoicedQuantity", "10");
		$feInvoiceLine -> appendChild($cbcInvoicedQuantity);

		$cbcLineExtensionAmount =$xml -> createElement("cbc:LineExtensionAmount", "100");
		$cbcLineExtensionAmount -> setAttribute("currencyID", "COP");
		$feInvoiceLine -> appendChild($cbcLineExtensionAmount);

		$feItem =$xml -> createElement("fe:Item");
		$feInvoiceLine -> appendChild($feItem);

			$cbcDescription =$xml -> createElement("cbc:Description", "Línea-1 8110007869 fos0001_900373076_8bad2_R000001-81-26610");
			$feItem -> appendChild($cbcDescription);

		$fePrice =$xml -> createElement("fe:Price");
		$feInvoiceLine -> appendChild($fePrice);

			$cbcPriceAmount =$xml -> createElement("cbc:PriceAmount", "43256");
			$cbcPriceAmount -> setAttribute("currencyID", "COP");
			$fePrice -> appendChild($cbcPriceAmount);

	$feInvoiceLine2 =$xml -> createElement("fe:InvoiceLine");
	$Invoice -> appendChild($feInvoiceLine2);

		$cbcID7 =$xml -> createElement("cbc:ID", "2");
		$feInvoiceLine2 -> appendChild($cbcID7);

		$cbcInvoicedQuantity2 =$xml -> createElement("cbc:InvoicedQuantity", "10");
		$feInvoiceLine2 -> appendChild($cbcInvoicedQuantity2);

		$cbcLineExtensionAmount2 =$xml -> createElement("cbc:LineExtensionAmount", "100");
		$cbcLineExtensionAmount2 -> setAttribute("currencyID", "COP");
		$feInvoiceLine2 -> appendChild($cbcLineExtensionAmount2);


		$cacTaxTotal =$xml -> createElement("cac:TaxTotal");
		$feInvoiceLine2 -> appendChild($cacTaxTotal);

			$cbcTaxAmount3  =$xml -> createElement("cbc:TaxAmount", "20.14");
			$cbcTaxAmount3 -> setAttribute("currencyID", "COP");
			$cacTaxTotal -> appendChild($cbcTaxAmount3);

			$cacTaxSubtotal  =$xml -> createElement("cac:TaxSubtotal");
			$cacTaxTotal -> appendChild($cacTaxSubtotal);

				$cbcTaxAmount4  =$xml -> createElement("cbc:TaxAmount", "16");
				$cbcTaxAmount4 -> setAttribute("currencyID", "COP");
				$cacTaxSubtotal -> appendChild($cbcTaxAmount4);

				$cbcPercent3  =$xml -> createElement("cbc:Percent", "16");
				$cacTaxSubtotal -> appendChild($cbcPercent3);	

				$cacTaxCategory3  =$xml -> createElement("cac:TaxCategory");
				$cacTaxSubtotal -> appendChild($cacTaxCategory3);	

					$cacTaxScheme4  =$xml -> createElement("cac:TaxScheme");
					$cacTaxCategory3 -> appendChild($cacTaxScheme4);	

						$cbcID8 = $xml -> createElement("cbc:ID", "01");
						$cacTaxScheme4 -> appendChild($cbcID8);

			$cacTaxSubtotal2  =$xml -> createElement("cac:TaxSubtotal");
			$cacTaxTotal -> appendChild($cacTaxSubtotal2);

				$cbcTaxAmount5  =$xml -> createElement("cbc:TaxAmount", "4.14");
				$cbcTaxAmount5 -> setAttribute("currencyID", "COP");
				$cacTaxSubtotal2 -> appendChild($cbcTaxAmount5);

				$cbcPercent4  =$xml -> createElement("cbc:Percent", "4.14");
				$cacTaxSubtotal2 -> appendChild($cbcPercent4);	

				$cacTaxCategory4  =$xml -> createElement("cac:TaxCategory");
				$cacTaxSubtotal2 -> appendChild($cacTaxCategory4);	

					$cacTaxScheme5  =$xml -> createElement("cac:TaxScheme");
					$cacTaxCategory4 -> appendChild($cacTaxScheme5);	

						$cbcID9 = $xml -> createElement("cbc:ID", "03");
						$cacTaxScheme5 -> appendChild($cbcID9);

		
		$feItem2 =$xml -> createElement("fe:Item");
		$feInvoiceLine2 -> appendChild($feItem2);

			$cbcDescription2 =$xml -> createElement("cbc:Description", "Línea-1 8110007869 fos0001_900373076_8bad2_R000001-81-26610");
			$feItem2 -> appendChild($cbcDescription2);

		$fePrice2 =$xml -> createElement("fe:Price");
		$feInvoiceLine2 -> appendChild($fePrice2);

			$cbcPriceAmount2 =$xml -> createElement("cbc:PriceAmount", "43256");
			$cbcPriceAmount2 -> setAttribute("currencyID", "COP");
			$fePrice2 -> appendChild($cbcPriceAmount2);

	echo "<xmp>".$xml->saveXML()."</xmp>";  

	$xml -> save("books_report1.xml") or die ("Error, Unable to create XML File");
?>