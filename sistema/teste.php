<%@taglib uri="/WEB-INF/lib/mentawai.jar" prefix="mtw"%>
<%@ page language="java" import="java.util.*"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
   <title>InputMoney</title>
   <mtw:inputMoneyConfig />
</head>
<body>
  <form>
   <table align="left">
      <tr>
            <td>Valor Padrão Brasileiro:</td>
      </tr>
      <tr>
            <td><mtw:inputMoney name="moneyBr" decimals="2" dec_point=","
                  thousands_sep="." textAlign="right" /></td>
      </tr>
      <tr>
            <td>Valor Padrão Americano:</td>
      </tr>
      <tr>
            <td><mtw:inputMoney name="moneyUs" decimals="2" dec_point="."
                  thousands_sep="," textAlign="right" /></td>
      </tr>
   </table>
  </form>
</body>
</html>