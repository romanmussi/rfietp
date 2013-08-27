REM  *****  BASIC  ***** 

Sub Main 
	MakeItPlain() 
End Sub 

Sub MakeItPlain() 
    
    if(CheckTabs) then 
	    if(CheckColumns) then 
	    	SaveDocument 
	        mensaje = ProcessRows() 
		    MsgBox "Enhorabuena! El Proceso terminó de forma Correcta \n" + mensaje 
		else 
			MsgBox "Ups! Las columnas del archivo no estan en el orden estandar, chequee el orden de las mismas" 
		end if 
	else 
		MsgBox "Ups! El nombre de los Tabs debe tener el siguiente formato #º-####. Ej.: 1º-2006" 
	end if 
 
End Sub 


function ProcessRows as string 
	Dim oSheet as object, oCell as object, oRange as object, oArrayData as object 
	Dim iColumn as integer, iRow as integer,iSheet as integer, iEmptyCells as integer, iMaxEmptyRows as integer, iTotalSheets as integer 
	Dim noBorders As New com.sun.star.table.BorderLine 
	Dim lastJurisdiccion as string 
	Dim errorMje as string 
	 
	iTotalSheets = ThisComponent.Sheets.Count - 1 
	 
	noBorders.Color = 0 
	noBorders.InnerLineWidth = 0 
	noBorders.OuterLineWidth = 0 
	noBorders.LineDistance = 0 
	 
	iColumn = 0 
	iMaxEmptyCells = 10 
	iDataRows = 0 
	iDeletedRows = 0 
	iLineasAccion = 0 
	 
	 
	for iSheet = 0 to iTotalSheets 
		oSheet = ThisComponent.Sheets.getByIndex(iSheet) 
		 
		oSheet.LeftBorder = noBorders 
	 	oSheet.RightBorder = noBorders 
	 	oSheet.BottomBorder = noBorders 
	 	oSheet.TopBorder = noBorders 
	 	 
	 	selectSheetByIndex(iSheet) 
		ResetAttributes(oSheet) 
		 
		Curs = oSheet.createCursor 
		Curs.gotoEndOfUsedArea(True) 
		iTotalRows = Curs.Rows.Count - 1 
		 
		loadLineas(oSheet, iTotalRows + 1) 
		 
		for iRow = 0 to iTotalRows 
		 
				iEmptyCells = 0 
				headerCounter = 0 
				exitNow = false 
				isTotalRow = false 
				 
				for iColumn = 1  to 35 
				 	oCell = oSheet.getCellByPosition(iColumn,iRow) 
				 	if( not isTotalRow and iEmptyCells < 8 and iColumn > 8 and iColumn < 33 and Trim(oCell.getString) <> "" and IsNumeric(oCell.getString)) then 
				 		iLineasAccion = iLineasAccion + 1 
				 	elseif(iEmptyCells = 6) then 
				 		isTotalRow = true 
				 	end if			 		 
				 		 
				 	if (not exitNow) then 
				 		if (Trim(oCell.getString) = "" or Trim(oCell.getString) = 0) then 
							iEmptyCells 	= iEmptyCells + 1 
						elseif (oCell.getString = "Provincia" or oCell.getString = "Memo Nº") then 
							headerCounter = headerCounter + 1 
							if(headerCounter = 2) then 
								iEmptyCells = iMaxEmptyCells 
								exitNow = true 
							end if 
						else 
							if(iColumn <> 1) then 
								iEmptyCells = 0 
								exitNow = true 
							end if 
						end if 
					end if 
				next iColumn 
				 
				if  (iEmptyCells >= iMaxEmptyCells and iRow <> iTotalRows ) then 
						oSheet.getRows.removeByIndex(iRow,1) 
						iDeletedRows = iDeletedRows + 1 
						if(iRow <> 0) then 
							iRow = iRow -1 
							iTotalRows = iTotalRows -1 
						end if 
				else 
					iDataRows = iDataRows + 1 
				end if 
		next iRow 
		 
		oSheet.getRows.removeByIndex(0,1) 
		iDeletedRows = iDeletedRows + 1 
		iDataRows = iDataRows - 1 
		 
		iTotalRows = iTotalRows -1 
		 
		insertColumn(4, "B") 
					 				 	 
	 	loadRowTypes(oSheet, iTotalRows) 
	 	 
	 	loadAnioTrimestre(oSheet,iTotalRows) 
	 	 
	 	errorJuris = assignJurisdiccion(oSheet,iTotalRows) 
	 	if(errorJuris <> "")then 
	 		errorMje = errorMje + errorJuris 
	 	end if 
		 
	next iSheet 
	 
	InsertNewSheet 
	 
	MergeSheets 
	 
	ChangeNumberFormat 
	 
	mensaje = "-----------------------------------------" +  Chr(13) + Chr(10) 
	mensaje = "Total de Lineas de Datos: " + iDataRows +  Chr(13) + Chr(10) 
	mensaje = mensaje + "Total Lineas Borradas: " + iDeletedRows + Chr(13) + Chr(10) 
	mensaje = mensaje + "Total de Lineas de Accion: " + iLineasAccion + Chr(13) + Chr(10) 
	mensaje = mensaje + "Warnings:" + Chr(13) + Chr(10) 
	mensaje = mensaje + errorMje 
	 
	ProcessRows = mensaje 
end function 

private Sub selectSheetByIndex(iSheet) 
  ThisComponent.CurrentController.select(ThisComponent.Sheets(iSheet)) 
End Sub 

private Function selectJurisdiccion(nombre as string) as integer 
	Dim jurisdiccion_id as integer 
	 
	nombre = RTrim(LTrim(nombre)) 
	 
	Select Case nombre 
		case "Ciudad" 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "Ciudad Bs. As." 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "CABA" 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "C.A.B.A" 
			jurisdiccion_id = "2" 
		case "C.A.B.A." 
			jurisdiccion_id = "2" 
		case "Ciudad" 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "Ciudad Autónoma" 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "Ciudad Autonoma" 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "Ciudad Autónoma de Buenos Aires" 
			jurisdiccion_id = "2" 
			nombre = "C.A.B.A" 
		case "Buenos" 
			jurisdiccion_id = "6" 
			nombre = "Buenos Aires" 
		case "Buenos " 
			jurisdiccion_id = "6" 
			nombre = "Buenos Aires" 
		case "Buenos Aires" 
			jurisdiccion_id = "6" 
		case "Bs. As." 
			jurisdiccion_id = "6" 
			nombre = "Buenos Aires" 
		case "Aires" 
			jurisdiccion_id = "6" 
			nombre = "Buenos Aires" 
		case "Catamarca" 
			jurisdiccion_id = "10" 
		case "Córdoba" 
			jurisdiccion_id = "14" 
		case "Cordoba" 
			jurisdiccion_id = "14" 
		case "Corrientes" 
			jurisdiccion_id = "18" 
		case "Chaco" 
			jurisdiccion_id = "22" 
		case "Chubut" 
			jurisdiccion_id = "26" 
		case "Entre Rios" 
			jurisdiccion_id = "30" 
		case "Entre Ríos" 
			jurisdiccion_id = "30" 
		case "Formosa" 
			jurisdiccion_id = "34" 
		case "Jujuy" 
			jurisdiccion_id = "38" 
		case "La Pampa" 
			jurisdiccion_id = "42" 
		case "La Rioja" 
			jurisdiccion_id = "46" 
		case "Mendoza" 
			jurisdiccion_id = "50" 
		case "Misiones" 
			jurisdiccion_id = "54" 
		case "Neuquen" 
			jurisdiccion_id = "58" 
		case "Neuquén" 
			jurisdiccion_id = "58" 
		case "Río Negro" 
			jurisdiccion_id = "62" 
		case "Rio Negro" 
			jurisdiccion_id = "62" 
		case "Salta" 
			jurisdiccion_id = "66" 
		case "San Juan" 
			jurisdiccion_id = "70" 
		case "San Luis" 
			jurisdiccion_id = "74" 
		case "Santa Cruz" 
			jurisdiccion_id = "78" 
		case "Santa Fe" 
			jurisdiccion_id = "82" 
		case "Santiago del Estero" 
			jurisdiccion_id = "86" 
		case "Santiago" 
			jurisdiccion_id = "86" 
			nombre = "Santiago del Estero" 
		case "del Estero" 
			jurisdiccion_id = "86" 
			nombre = "Santiago del Estero" 
		case "Tucumán" 
			jurisdiccion_id = "90" 
		case "Tucuman" 
			jurisdiccion_id = "90" 
		case "Tierra del Fuego" 
			jurisdiccion_id = "94" 
		case "Tierra del" 
			jurisdiccion_id = "94" 
			nombre = "Tierra del Fuego" 
		case "Tierra" 
			jurisdiccion_id = "94" 
			nombre = "Tierra del Fuego" 
		case "Fuego" 
			jurisdiccion_id = "94" 
			nombre = "Tierra del Fuego" 
		case "del Fuego" 
			jurisdiccion_id = "94" 
			nombre = "Tierra del Fuego" 
		case else 
			jurisdiccion_id = 0 
	End Select 
	 
	selectJurisdiccion = jurisdiccion_id 
end function 

private function assignJurisdiccion(oSheet as object, iTotalRows as integer) 
	Dim lastJurisdiccion as string 
	Dim errorMje as string 
	dim provincias(95) as new com.sun.star.beans.PropertyValue 
	dim iCant as integer 
		 
	for iRow = 0 to iTotalRows - 1 
		 	oCell = oSheet.getCellByPosition(5,iRow) 
		 								 		 	 
	 		if(oCell.getString <> "") then 
	 			provincias(jurisdiccion_id).Value = iCant 
	 			iCant = 0 
				 
	 			lastJurisdiccion = oCell.getString 
	 			jurisdiccion_id =  selectJurisdiccion(lastJurisdiccion) 
	 		 
		 		if(jurisdiccion_id = 0) then 
		 			errorMje = errorMje + "No se identificó la jurisdiccion: " + lastJurisdiccion + " en la pestaña " + oSheet.Name + Chr(13) + Chr(10) 
		 		else 
		 			provincias(jurisdiccion_id).Name = lastJurisdiccion 
		 		end if 
	 		end if 
	 		 
	 		jurisdiccion_id =  selectJurisdiccion(lastJurisdiccion) 
	 		 
	 		oCell.String = lastJurisdiccion 
	 		 
	 		oCell = oSheet.getCellByPosition(4,iRow) 
	 		 
	 		oCell.String = jurisdiccion_id 
	 		 
	 		iCant = iCant + 1 
	 			 			 
	next iRow 
	 
	assignJurisdiccion = errorMje 
	 
end function 

private sub insertColumn(numberOfColumns as integer, position as string) 
	dim document   as object 
	dim dispatcher as object 
	 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
	 
	dim args1(0) as new com.sun.star.beans.PropertyValue 
	args1(0).Name = "ToPoint" 
	args1(0).Value = "$" + position + "$1" 
	 
	for i=0 to numberOfColumns - 1 
		dispatcher.executeDispatch(document, ".uno:GoToCell", "", 0, args1()) 
		dispatcher.executeDispatch(document, ".uno:InsertColumns", "", 0, Array()) 
	next i 
end sub 

private sub loadAnioTrimestre(oSheet as object, iTotalRows as integer) 
		 
	for iRow = 0 to iTotalRows - 1 
			for iColumn = 2  to 3 
			 	oCell = oSheet.getCellByPosition(iColumn,iRow) 
			 	 
			 	if(iColumn = 2) then 
			 		oCell.String = Right(oSheet.Name, 4) 
			 	else 
			 		oCell.String = Left(oSheet.Name, 1) 
			 	end if	 
			next iColumn 
	next iRow 
end sub 

private sub loadRowTypes(oSheet as object, iTotalRows as integer) 
		 
	for iRow = 0 to iTotalRows - 1 
			oCell = oSheet.getCellByPosition(7,iRow) 
		 								 		 	 
	 		if(oCell.getString <> "") then 
	 			celltype = "i" 
	 		else 
	 			oCellInstit = oSheet.getCellByPosition(8,iRow) 
	 			oCellNombre = oSheet.getCellByPosition(9,iRow) 
	 			 
	 			if(oCellInstit.getString = "") then 
	 				if(oCellNombre.getString = "") then 
	 					celltype = "t" 
	 				else 
			 			celltype = "j" 
	 				end if 
	 			else	 			 
		 			celltype = "j" 
	 			end if 
	 		end if 
	 		 
	 		oCell = oSheet.getCellByPosition(1,iRow) 
	 		oCell.String = celltype 
	 		 
	next iRow 
end sub 

private sub loadLineas(oSheet as object, iTotalRows as integer) 
		 
	insertColumn(1,"A") 
	 
	for iRow = 0 to iTotalRows - 1 
			oCell = oSheet.getCellByPosition(0,iRow) 
	 		oCell.String = iRow	+ 1 
	next iRow 
end sub 

private sub ResetAttributes(oSheet as object) 
	dim document   as object 
	dim dispatcher as object 
			 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
	 
	dispatcher.executeDispatch(document, ".uno:SelectAll", "", 0, Array())		 
	dispatcher.executeDispatch(document, ".uno:ResetAttributes", "", 0, Array()) 
	 
	'dim args1(0) as new com.sun.star.beans.PropertyValue 
'	args1(0).Name = "NumberFormatValue" 
'	args1(0).Value = 15000 
	 
'	dispatcher.executeDispatch(document, ".uno:NumberFormatValue", "", 0, args1()) 
		 
end sub 

private sub DeleteAllCell(oCell as object) 
	dim document   as object 
	dim dispatcher as object 
			 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
			 
	dispatcher.executeDispatch(document, ".uno:ResetAttributes", "", 0, Array()) 
	oCell.String = "" 
		 
end sub 

private sub InsertNewSheet() 
	nNumSheetsCurrently = ThisComponent.getSheets().getCount() 
  	ThisComponent.getSheets().insertNewByName( "Procesado", nNumSheetsCurrently + 1 ) 
end sub 


sub MergeSheets 
	iTotalSheets = ThisComponent.Sheets.Count - 1 
	 
	for iSheet = 0 to (iTotalSheets - 1) 
		CopyPasteSheet(iSheet,iTotalSheets) 
	next iSheet 
end sub 

private sub CopyPasteSheet(sourceSheetNumber as integer,destSheetNumber as integer) 

	dim document   as object 
	dim dispatcher as object 
	 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
	 
	selectSheetByIndex(sourceSheetNumber) 
	 
	dim args1(0) as new com.sun.star.beans.PropertyValue 
	args1(0).Name = "ToPoint" 
	args1(0).Value = "$A$1" 
	 
	dispatcher.executeDispatch(document, ".uno:GoToCell", "", 0, args1()) 
	 
	dim args2(0) as new com.sun.star.beans.PropertyValue 
	args2(0).Name = "Sel" 
	args2(0).Value = true 
	 
	dispatcher.executeDispatch(document, ".uno:GoToEndOfData", "", 0, args2()) 
	dispatcher.executeDispatch(document, ".uno:Copy", "", 0, Array()) 
	 
	selectSheetByIndex(destSheetNumber) 
		 
	oSheet = ThisComponent.Sheets.getByIndex(destSheetNumber) 
		 
	Curs = oSheet.createCursor 
	Curs.gotoEndOfUsedArea(True) 
	iTotalRows = Curs.Rows.Count 
	 
	if(iTotalRows > 1) then 
		iTotalRows = iTotalRows + 1 
	end if 
	 
	dim args3(0) as new com.sun.star.beans.PropertyValue 
	args3(0).Name = "ToPoint" 
	args3(0).Value = "$A$" + iTotalRows 
			 
	dispatcher.executeDispatch(document, ".uno:GoToCell", "", 0, args3()) 
		 
	'dispatcher.executeDispatch(document, ".uno:Paste", "", 0, Array()) 
	dim args4(5) as new com.sun.star.beans.PropertyValue 
	args4(0).Name = "Flags" 
        args4(0).Value = "SVD" 
        args4(1).Name = "FormulaCommand" 
        args4(1).Value = 0 
        args4(2).Name = "SkipEmptyCells" 
        args4(2).Value = false 
        args4(3).Name = "Transpose" 
        args4(3).Value = false 
        args4(4).Name = "AsLink" 
        args4(4).Value = false 
        args4(5).Name = "MoveMode" 
        args4(5).Value = 4 

        dispatcher.executeDispatch(document, ".uno:InsertContents", "", 0, args4()) 

end sub 

function CheckColumns() as boolean 
	Dim oSheet as object, oCell as object 
	Dim iColumn as integer, iRow as integer,iSheet as integer, iTotalSheets as integer 
	Dim standardColumns(34) As String 

	standardColumns(0) = "provincia" 
	standardColumns(1) = "memo nº" 
	standardColumns(2) = "cue" 
	standardColumns(3) = "inst./juris." 
	standardColumns(4) = "obs" 
	standardColumns(5) = "nombre del establecimiento" 
	standardColumns(6) = "departamento" 
	standardColumns(7) = "localidad" 
	standardColumns(8) = "f01" 
	standardColumns(9) = "f02 a" 
	standardColumns(10) = "f02 b" 
	standardColumns(11) = "f02 c" 
	standardColumns(12) = "f03 a" 
	standardColumns(13) = "f03 b" 
	standardColumns(14) = "f04" 
	standardColumns(15) = "f05" 
	standardColumns(16) = "f06 a" 
	standardColumns(17) = "f06 b" 
	standardColumns(18) = "f06 c" 
	standardColumns(19) = "f07 a" 
	standardColumns(20) = "f07 b" 
	standardColumns(21) = "f07 c" 
	standardColumns(22) = "f08" 
	standardColumns(23) = "f09" 
	standardColumns(24) = "f10" 
	standardColumns(25) = "equp.inf" 
	standardColumns(26) = "refacción" 
	standardColumns(27) = "aula_movil" 
	standardColumns(28) = "c1" 
	standardColumns(29) = "c2" 
	standardColumns(30) = "c3" 
	standardColumns(31) = "c4" 
	standardColumns(32) = "c5" 
	standardColumns(33) = "total"	 
	 
	iTotalSheets = ThisComponent.Sheets.Count - 1 
	iCantColumns = UBound(standardColumns) - LBound(standardColumns) 
			 
	for iSheet = 0 to iTotalSheets 
		oSheet = ThisComponent.Sheets.getByIndex(iSheet) 
					 	 
	 	selectSheetByIndex(iSheet) 
		 
		Curs = oSheet.createCursor 
		Curs.gotoEndOfUsedArea(True) 
		iTotalRows = Curs.Rows.Count - 1 
		 
		CheckColumns = true 
				 
		for iRow = 0 to iTotalRows 
				headerHit = false	 
				for iColumn = 0  to iCantColumns + 5 
					 
					oCell = oSheet.getCellByPosition(iColumn,iRow) 
					 
					if(iColumn > iCantColumns - 1) then 
						ThisComponent.CurrentController.select(oCell) 
						DeleteAllCell(oCell) 
					else 
					 	if (oCell.getString <> ""  and (oCell.getString like (standardColumns(0) + "*") or headerHit)) then	 
					 		headerHit = true 
					 		NormalizeCell(oCell)				 
							if(oCell.getString <> "" and (standardColumns(iColumn) like LCase(oCell.getString) + "*")) then 
								ThisComponent.CurrentController.select(oCell) 
								ChangeColor(3394662) 'verde 
							else 
								ThisComponent.CurrentController.select(oCell) 
								CreateNote(oCell,standardColumns(iColumn) ) 
								ChangeColor(16744576) 'rojo 
								CheckColumns = false 
							end if 
						elseif (oCell.getString = "" and headerHit) then 
							ThisComponent.CurrentController.select(oCell) 
							CreateNote(oCell,standardColumns(iColumn) ) 
							ChangeColor(16744576) 'rojo 
							CheckColumns = false 
						else 
							exit for 
						end if	 
					end if 
				next iColumn 
				 
				if(headerHit) then 
					exit for 
				end if 
		next iRow 		 
	next iSheet 
	 
end function 

function CheckTabs() as boolean 
	Dim oSheet as object, oCell as object 
	Dim iColumn as integer, iRow as integer,iSheet as integer, iTotalSheets as integer 
	Dim tabName as string 
	Dim checked as boolean 
	 
	checked = true 

	iTotalSheets = ThisComponent.Sheets.Count - 1 
			 
	for iSheet = 0 to iTotalSheets 
		oSheet = ThisComponent.Sheets.getByIndex(iSheet) 
		tabName = oSheet.Name 
		 
		possibleYear = Right(tabName, 4) 
		checked = checked and StartsWith(possibleYear, "20") 
	next iSheet 
	 
	CheckTabs = checked 
end function 

Private Function StartsWith(ByVal test_string As String, _ 
    ByVal target As String) As Boolean 
    StartsWith = (Left$(test_string, Len(target)) = target) 
End Function 
 

sub ChangeColor(color as double) 

	dim document   as object 
	dim dispatcher as object 
	dim args1(0) as new com.sun.star.beans.PropertyValue 
	dim args2(0) as new com.sun.star.beans.PropertyValue 
	 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
			 
	args2(0).Name = "BackgroundColor" 
	args2(0).Value = color '3394662 -> verde 
	 
	dispatcher.executeDispatch(document, ".uno:BackgroundColor", "", 0, args2()) 

end sub 

sub NormalizeCell(oCell as object) 
	if(InStr(oCell.String, "-->") > 0) then 
		oCell.String = Left(oCell.String, InStr(oCell.String, "-->") - 1) 
	end if 
	oCell.String = LTrim(oCell.String) 
	oCell.String = RTrim(oCell.String) 
end sub 

sub CreateNote(oCell as object,note as string) 

	oCell.Annotation.String = note  
	oCell.Annotation.IsVisible = True 
	oCell.String = oCell.String + " --> " + note 

end sub 

Sub ChangeNumberFormat 

	Dim aLocale as new com.sun.star.lang.Locale, oDoc as Object 
	dim oSelect as Object, sFormat as String, vNumFormat 
	dim document   as object 
	dim dispatcher as object 
			 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
	 
	selectNumbers 
	 
	aLocale.Language = "en" : aLocale.Country = "AU" 'optional 
	 
	oDoc = ThisComponent : oSelect = oDoc.CurrentSelection : sFormat = "0.0" 
	 
	vNumFormat = oDoc.getNumberFormats().queryKey( sFormat, aLocale, TRUE) 
	 
	If ( vNumFormat = -1 ) Then 
		vNumFormat = oDoc.getNumberFormats().addNew ( sFormat, aLocale ) 
	End If 
	 
	oSelect.NumberFormat = vNumFormat 

End Sub 


sub selectNumbers 
	dim document   as object 
	dim dispatcher as object 

	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 

	dim args1(0) as new com.sun.star.beans.PropertyValue 
	args1(0).Name = "ToPoint" 
	args1(0).Value = "$M$1" 
	 
	dispatcher.executeDispatch(document, ".uno:GoToCell", "", 0, args1()) 
	 
	dim args2(0) as new com.sun.star.beans.PropertyValue 
	args2(0).Name = "Sel" 
	args2(0).Value = true 
	 
	dispatcher.executeDispatch(document, ".uno:GoToEndOfData", "", 0, args2()) 


end sub 


sub SaveDocument 
	rem ---------------------------------------------------------------------- 
	rem define variables 
	dim document   as object 
	dim dispatcher as object 
	rem ---------------------------------------------------------------------- 
	rem get access to the document 
	document   = ThisComponent.CurrentController.Frame 
	dispatcher = createUnoService("com.sun.star.frame.DispatchHelper") 
	 
	rem ---------------------------------------------------------------------- 
	dispatcher.executeDispatch(document, ".uno:Save", "", 0, Array()) 


end sub

