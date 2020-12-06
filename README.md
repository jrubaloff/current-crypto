# Current Crypto

## Get cryptocurrency data in your Excel spreadsheets on Mac

Windows users can use the Power Query Editor in Excel. Power Query Editor is not currently available in Mac version of Excel. Mac users can use VBA to author Power Queries. This is what I came up with to “quickly” get current cryptocurrency prices in my Excel spreadsheets on my Mac.

1. Create a free developer account on CoinMarketCap: https://pro.coinmarketcap.com/
2. Copy config.sample.php to config.php and set your API key from CoinMarketCap. Also change the currency if you aren’t USD.
3. Attach this repository to a host on a local web server. You can use whatever host name you want, but I used http://current-crypto/
4. Modify the IQY file in this repository by changing the URL to what you used in your web server configuration.
5. Add a worksheet to your spreadsheet. I called mine “Prices”
6. Select first cell of new worksheet and then choose Data > Get External Data > Run Web Query in Excel. In the dialog, select the IQY file in this repository.
7. Wherever you need a price, use this formula: ```=INDEX(Prices!B:B, MATCH(A2, Prices!A:A, 0))``` You can also use VLOOKUP but the former copies better and has other benefits.
8. Use a similar formula with the other columns of data as you see fit.
9. To update your spreadsheet, select Refresh All on the Data tab.
